<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Developer;
use App\Models\Property;
use \Carbon\Carbon;
use Propaganistas\LaravelIntl\Facades\Country;
use App\Models\GalleryImage;
use View;
use Validator;
use Form;
use Input;
use Session;

class DeveloperController extends Controller
{
    public function index(){
        return view::make('admin.dev_add')->render();
    }
    public function edit($id)
    {
        $data['data'] = Developer::find($id);
        return View::make('admin.dev_add',$data)->render();
    }
    public function save(Request $r, Developer $dev)
    {
        $inputs = $r->all();
        $rules = [
            'dev_name' => 'required|max:150',
        ];
        $message = [
            'dev_name.required' => 'Please Enter Developer Name',
            'dev_name.max' => 'You have exceeded the maximum characters allowed',
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if(!$validator->fails()){
            if (isset($inputs['dev_id'])) {
                $updev = $dev->find($inputs['dev_id']);
                $updev->dev_name = $inputs['dev_name'];
                $updev->dev_slug = $inputs['dev_slug'];
                $updev->dev_desc = $inputs['dev_desc'];
                $updev->dev_image = $inputs['dev_image'];
                $result = $updev->save();
            }else{
                $dev->dev_name = $inputs['dev_name'];
                $dev->dev_slug = $inputs['dev_slug'];
                $dev->dev_desc = $inputs['dev_desc'];
                $dev->dev_image= $inputs['dev_image'];
                $result = $dev->save();
            }
            
            if($result){
                if (isset($inputs['dev_id'])) {
                    Session::flash('success', 'Developer Updated Successfully'); 
                }else{
                    Session::flash('success', 'Developer Added Successfully'); 
                }
                return redirect('/admin/dev');
            }else{
                Session::flash('success', 'There was an error. If this persist again please contact your it personel'); 
                return redirect('/admin/dev');
            }
            
        }else{
            $r->flash();
            return view('admin.dev_add')->withErrors($validator)->render();
        }
    }
    public function list(Developer $dev){
        $devs = $dev->leftJoin('gallery_images','gallery_images.img_id','=','developer.dev_image')
                            ->get();
        foreach ($devs as $key => $value) {
            $img = $devs[$key]->img_path;
                $parths = explode('/', $img);
                if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                    $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                }else{
                    $thumb_file = $img;
            }
            $dirs[$key]['name'] = $devs[$key]->dev_name;
            $dirs[$key]['img'] = $thumb_file;
            $dirs[$key]['slug'] = 'developer/'.$devs[$key]->dev_slug;
            $dirs[$key]['blurb'] = $devs[$key]->dev_desc;
        }
        $data['country'] = Country::all();
        $data['dirs'] = $dirs;
        $data['pags'] = $devs;
        $data['sec'] = 'Developers';
        
        return View::make('properties.dev_com',$data)->render();

    }
    public function view(Property $prop,Developer $dev,Carbon $c, $slug){
        $data['props'] = $prop->leftjoin('developer','developer.dev_id','=','property.prop_developer')
                                  ->leftjoin('location','location.loc_id','=','property.prop_location')
                                  ->leftjoin('gallery_images','gallery_images.img_id','=','property.prop_featured_image')
                                  ->leftjoin('gallery_images as dev_img','dev_img.img_id','=','developer.dev_image')
                                  ->select('gallery_images.img_path','location.loc_name','property.prop_name','property.prop_developer','property.prop_type','property.prop_date_fin','property.prop_date_null','property.prop_code','property.prop_area','property.prop_slug','property.prop_bed','property.prop_price','dev_img.img_path as dev_img')
                                  ->where('dev_slug',$slug)->where('prop_status','1')->paginate(8);
        $data['dev_det'] = $dev->leftjoin('gallery_images','gallery_images.img_id','=','developer.dev_image')->where('dev_slug',$slug)
                                ->select('gallery_images.img_path','developer.dev_name','developer.dev_slug','developer.dev_desc')->first();
        if(sizeof($data['props'])){
            foreach ($data['props'] as $key => $value) {
                $img = $data['props'][$key]->img_path;
                $parths = explode('/', $img);
                $thumb_file = $img;
                if(file_exists($parths[0] . '/thumbs/' . $parths[1]) && (app('mobile-detect')->isMobile() || app('mobile-detect')->isTablet())){
                     if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                        $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                    }
                }else if(!app('mobile-detect')->isMobile()){
                    if(file_exists($parths[0] . '/thumbs_desk/' . $parths[1])){
                        $thumb_file = $parths[0] . '/thumbs_desk/' . $parths[1];
                    }else if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                        $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                    }
                }
                $d_img = $data['props'][$key]->dev_img;
                $d_parths = explode('/', $d_img);
                $d_thumb_file = $img;
                if(file_exists($d_parths[0] . '/tiny/' . $d_parths[1])){
                        $d_thumb_file = $d_parths[0] . '/tiny/' . $d_parths[1];
                }
                $data['props'][$key]->prop_img = $thumb_file;
                $data['props'][$key]->dev_img = $d_thumb_file;
                $data['props'][$key]->prop_loc = $data['props'][$key]->loc_name;
                $date = $c->parse($data['props'][$key]->prop_date_fin);
                $data['props'][$key]->finished = ($c->now()->diffInDays($date,false) <= 0) ? 1 : 0 ;
                $data['props'][$key]->date_fin = 'Q' . $date->quarter . ' ' . $date->year;
            }
            $data['slug'] =  $data['dev_det']->dev_name;
            $data['li'] =  $slug;
            $data['country'] = Country::all();
            return View::make('properties.developers',$data)->render();
        }else{
            return View::make('errors.404');
        }
    }
    public function delete($id)
    {
        if (Developer::find($id)->delete()) {
            Session::flash('success', 'Developer Deleted Successfully'); 
            return redirect('/admin/dev');
        }else{
            Session::flash('success', 'There was an error in deleting the Developer. If this persist again please contact your IT personel'); 
            return redirect('/admin/dev');
        }
    }

}
