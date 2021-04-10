<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Location;
use App\Models\Developer;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Promonewproject;
use App\Models\File;
use App\Models\Tag;
use App\Models\TagsProp;
use App\Models\SpecialProperty;
use View;
use DB;
use Validator;
use Form;
use Input;
use Session;
use \Carbon\Carbon;
use Propaganistas\LaravelIntl\Facades\Country;

class PropertyController extends Controller
{
    public function index()
    {
        $data['sprop'] = SpecialProperty::where('sprop_status',1)->select('sprop_id','sprop_name')->get();
        return view::make('admin.prop_add',$data)->render();
    }

    public function save(Request $r)
    {
        $inputs = $r->except(['_token','prop_meta_keys']);
        $rules = [
                    'prop_name' => 'required|max:100',
                    'prop_location' => 'required',
                    'prop_type' => 'required',
                    'prop_content' => 'required',
                    'prop_featured_image' => 'required',
                    'prop_meta_desc' => 'required',
                    'prop_meta_key' => 'required',
                    'prop_meta_title' => 'required|max:50',
                ];
        $message = [
                        'prop_name.required' => 'Please Fill up this field it is required',
                        'prop_location.required' => 'Please Fill up this field it is required',
                        'prop_type.required' => 'Please Fill up this field it is required',
                        'prop_content.required' => 'Please Fill up this field it is required',
                        'prop_featured_image.required' => 'Please Select an Image',
                        'prop_meta_desc.required' => 'Please Fill up this field it is required',
                        'prop_meta_key.required' => 'Please Fill up this field it is required',
                        'prop_meta_title.required' => 'Please Fill up this field it is required',
                        'prop_name.max' => 'You Have Exceeded the maximum characters allowed( 100 characters)',
                        'prop_meta_desc.max' => 'You Have Exceeded the maximum characters allowed( 150 characters)',
                        'prop_meta_title.max' => 'You Have Exceeded the maximum characters allowed( 50 characters)'

                    ];
        $validator = Validator::make($inputs,$rules,$message);
        $inputs['prop_date_null'] = isset($inputs['prop_date_null']) ? 1 : 0;
        $inputs['prop_bed_null'] = isset($inputs['prop_bed_null']) ? 1 : 0;
        if (!$validator->fails()) {
            if(isset($inputs['prop_id'])){
                if(Property::where('prop_id',$inputs['prop_id'])->update($inputs)){
                    TagsProp::where('prop_id',$inputs['prop_id'])->delete();
                    $tags = strpos($inputs['prop_meta_key'],',');
                    if ($tags) {
                        foreach (explode(',',$inputs['prop_meta_key']) as $key => $value) {
                            $teghi = Tag::firstOrCreate(['tag_name'=>$value]);
                            $tagpr = TagsProp::updateOrCreate(['tags_id'=>$teghi->tags_id,'prop_id'=>$inputs['prop_id']]);
                        }
                    }else{
                        $teghi = Tag::firstOrCreate(['tag_name'=>$tags]);
                        $tagpr = TagsProp::updateOrCreate(['tags_id'=>$teghi->tags_id,'prop_id'=>$inputs['prop_id']]);
                    }
                    
                    Session::flash('success','Property Updated Successfuly');
                        return redirect('admin/prop');
                    }else{
                        Session::flash('Error','Something Went Wrong Please Try Again');
                        $r->flash();
                        return View::make('admin.prop_add');
                    }

            }else{
                $inputs['prop_slug'] = $inputs['prop_slug'] . rand(000000,999999);
                $inputs['prop_code'] = 'NLDP-' . rand(000000,999999);
                $res_prop = Property::insert($inputs);
                    if ($res_prop) {
                        foreach (explode(',',$inputs['prop_meta_key']) as $key => $value) {
                            $teghi = Tag::firstOrCreate(['tag_name'=>$value]);
                            $tagpr = TagsProp::updateOrCreate(['tags_id'=>$teghi->tags_id,'prop_id'=>$res_prop->prop_id]);
                        }
                        Session::flash('success','Property Added Successfuly');
                        return redirect('admin/prop');
                    }else{
                        Session::flash('Error','Something Went Wrong Please Try Again. If you did not change anyting this error will pop up please check your inputs');
                        $r->flash();
                        return View::make('admin.prop_add');
                    }
            }
        }else{
            $r->flash();
            return View::make('admin.prop_add')->withErrors($validator);
        }
    }
    public function edit($id)
    {
        $data['sprop'] = SpecialProperty::where('sprop_status',1)->select('sprop_id','sprop_name')->get();
        $data['data'] = Property::where('prop_id',$id)->first(); 
        return View::make('admin.prop_add',$data)->render();
    }
    public function view(Property $prop,SpecialProperty $sprop,Promonewproject $prom, $id,$preview=null)
    {
        $data['data'] = $prop->where('prop_status',1)
                    ->join('gallery_images as gal','gal.img_id','=','property.prop_featured_image')
                    ->join('location','location.loc_id','=','property.prop_location')
                    ->join('developer as devdet','devdet.dev_id','=','property.prop_developer')
                    ->join('gallery_images as devdim','devdim.img_id','=','devdet.dev_image')
                    ->select('property.*','devdet.dev_name','devdet.dev_slug','devdet.dev_desc','gal.img_path','devdim.img_path as dev_img','location.loc_name','location.loc_desc')
                    ->where('prop_slug',$id)
                    ->first();
        $data['data']->sprop_desc = $sprop->where('sprop_id',$data['data']->prop_community)->select('sprop_description')->first(); 
        //checking if its new or has a promo
        //
/*        $pronew = $sprop->where('sprop_properties','like','%'. $data['data']->prop_code .'%')->first();
        if(sizeof($pronew)){
            $data['pronew'] = $prom->where('pronew_properties','like','%'.$pronew->sprop_slug.'%')->where('pronew_status',1)->first();
            if (!$data['pronew']) {
                $data['pronew'] = $prom->where('pronew_properties','like','%'.$id.'%')->where('pronew_status',1)->first();
            }
        }else{
        }*/
        $data['pronew'] = $prom->where('pronew_properties','like','%'.$id.'%')->where('pronew_status',1)->first();
        //fetching beroom types
        //
        $data['pbeds'] = $prop->where('prop_name',$data['data']->prop_name)->where('prop_slug','<>',$id)->select('prop_slug','prop_bed','prop_bed_null','prop_type')->get();
        //finish date
        $carb = new Carbon;
        $date = $carb->parse($data['data']->prop_date_fin);
        $datens = $data['data']->prop_date_null;
        if($datens == 0){
            $data['data']->finished = ($carb->now()->diffInDays($date,false) <= 0) ? 1 : 0 ;
            $data['data']->f_date = 'Q' . $date->quarter . ' ' . $date->year;
        }else{
            $data['data']->null_date = $datens;
        }
        //paymentplan parser
        $data['data']->prop_content = str_replace('[payplan:', '<h2 class="text-center display-5" id="paymentplans">Payment Plan</h2>', $data['data']->prop_content);
        $data['data']->prop_content = str_replace('/payplan:]', '<p class="w-100 text-center">*Payment Plans are subject to change without prior notice</p>', $data['data']->prop_content);
        $data['data']->prop_content = str_replace('<div class="col-sm-12 col-xs-12" style="height: 60px;">', '<div class="col-12">', $data['data']->prop_content);
        $data['data']->prop_content = str_replace('<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="height: 60px;">', '<div class="col-12">', $data['data']->prop_content); 
        $data['data']->prop_content = str_replace('<h1>', '<h1 class="display-5 text-center">', $data['data']->prop_content);
        $data['data']->prop_content = str_replace('<h2>', '<h2 class="display-5 text-center">', $data['data']->prop_content);
        $data['data']->prop_content = str_replace('<h3>', '<h3 class="display-6 text-center pb-4"><hr />', $data['data']->prop_content);
        $data['data']->prop_content = str_replace('<h4>', '<h4 class="display-6 text-center pb-4"><hr />', $data['data']->prop_content);
        $data['data']->prop_content = str_replace('<h5>', '<h5 class="display-6 text-center pb-4"><hr />', $data['data']->prop_content);
        $data['data']->prop_content = explode('[breakhere]',$data['data']->prop_content);
        //file processing block
        if ($data['data']) {
            $fileids = explode(',', $data['data']->prop_file_ids);
            $files = File::whereIn('file_id', $fileids)->get();
            $data['data']->prop_loc = $data['data']->prop_location;
            $data['data']->img = $data['data']->img_path;
            $filepaths = [];
            foreach ($files as $key => $value) {
                if(preg_match('/Brochure/',$value->file_name)){
                    $filepaths['b'][$value->file_name] = $value->file_path;
                }else if(preg_match('/Payment Plan/',$value->file_name)){
                    $filepaths['p'][$value->file_name] = $value->file_path;
                }else if(preg_match('/Floor Plan/',$value->file_name)){
                    $filepaths['f'][$value->file_name] = $value->file_path;
                }else if(preg_match('/Availability/',$value->file_name)){
                    $filepaths['a'][$value->file_name] = $value->file_path;
                }else{
                    $filepaths['o'][$value->file_name] = $value->file_path;
                }
            }
            $data['data']->prop_files = $filepaths;

            //gallery & floor plan
            if (isset($data['data']->prop_gallery) || isset($data['data']->prop_floorplan)) {
                $imgpaths = Gallery::whereIn('gal_id', [$data['data']->prop_gallery,$data['data']->prop_floorplan])->select('gal_image_ids','gal_id')->get()->toArray();
                $imgids = [];
                $galids = [];
                $floids = [];
                foreach ($imgpaths as $key => $value) {
                    $imgidse = explode(',', substr($value['gal_image_ids'], 0,-1));
                    foreach ($imgidse as $k => $v) {
                        $imgids[] = $v;
                        if ($value['gal_id'] == $data['data']->prop_gallery) {
                            $galids[] = $v;
                        }else if($value['gal_id'] == $data['data']->prop_floorplan){
                            $floids[] = $v;
                        }
                    }
                }
                $imges = GalleryImage::whereIn('img_id',$imgids)->select('img_path','img_id')->get()->toArray();
                foreach ($imges as $key => $value) {
                    $parths = explode('/', $value['img_path']);
                    if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                        $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                    }else{
                        $thumb_file = $value['img_path'];
                    }
                    if(file_exists($parths[0] . '/tiny/' . $parths[1])){
                        $tiny_file = $parths[0] . '/tiny/' . $parths[1];
                    }else{
                        $tiny_file = $thumb_file;

                    }
                    $paths['thumbs'] =  $thumb_file;
                    $paths['tiny'] =  $tiny_file;
                    $paths['retina'] =  $value['img_path'];
                    list($paths['retinawidth'], $paths['retinaheight']) = getimagesize($_SERVER["DOCUMENT_ROOT"] . '/' . $value['img_path']);
                    list($paths['thumbswidth'], $paths['thumbsheight']) = getimagesize($_SERVER["DOCUMENT_ROOT"] . '/' . $thumb_file);
                    if (in_array($value['img_id'],$galids)) {
                        $gal[] = $paths;
                        $mobgal[] = [
                            'src' => asset($paths['retina']),
                            'w' => $paths['retinawidth'], 
                            'h' => $paths['retinaheight'], 
                            'msrc' => asset($paths['thumbs']), 
                            'title' => $data['data']->prop_name  
                            ];
                    }else if(in_array($value['img_id'],$floids)){
                        $flo[] = $paths;
                        $mobflo[] = [
                            'src' => asset($paths['retina']),
                            'w' => $paths['retinawidth'], 
                            'h' => $paths['retinaheight'], 
                            'msrc' => asset($paths['thumbs']), 
                            'title' => $data['data']->prop_name  
                            ];
                    }
                }
                $data['data']->images = isset($gal) ? $gal : null ;
                $data['data']->mobimages = isset($mobgal) ? json_encode($mobgal) : null ;
                $data['data']->fpimages = isset($flo) ? $flo : null ;
                $data['data']->mobfpimages = isset($mobflo) ? json_encode($mobflo) : null ;
            }
                $data['country'] = Country::all();


            /*//latest projects
            $data['rec'] = $prop->groupBy('prop_name')->orderBy('prop_date_up','desc')->where('prop_slug','<>',$data['data']->prop_slug)->limit(4)->get();
            foreach ($data['rec'] as $key => $value) {
                $data['rec'][$key]->prop_loc = Location::where('loc_id',$data['rec'][$key]->prop_location)->pluck('loc_name')->first();
                $img = GalleryImage::where('img_id',$data['rec'][$key]->prop_featured_image)->pluck('img_path')->first();
                $parths = explode('/', $img);
                if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                    $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                }else{
                    $thumb_file = $img;
                }
                $data['rec'][$key]->img = $thumb_file;
                $data['rec'][$key]->dev = Developer::where('dev_id',$value->prop_developer)->pluck('dev_name')->first();
                $data['rec'][$key]->dev_slug = 'developer/' . Developer::where('dev_id',$value->prop_developer)->pluck('dev_slug')->first();
                $data['rec'][$key]->slug = 'property/' . $data['rec'][$key]->prop_slug;
            }*/
            

            return View::make('properties.page',$data);
        }else{
            return View::make('errors.404');
        }
    }

    public function delete($id)
    {
        Property::where('prop_id',$id)->update(['prop_status'=>4]);
        Session::flash('success','Property Deleted Successfuly');
        return redirect('admin/prop');
    }
}
