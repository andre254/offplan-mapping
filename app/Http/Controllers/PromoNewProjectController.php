<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promonewproject;
use App\Models\Featured;
use App\Models\Property;
use App\Models\SpecialProperty;
use App\Models\Developer;
use App\Models\GalleryImage;
use App\Models\Location;
use View;
use Validator;
use Session;

class PromoNewProjectController extends Controller
{
    public function index(){

        return view::make('admin.pronew_add')->render();
    }
    public function edit($id)
    {
        $data['data'] = Promonewproject::find($id);
        return View::make('admin.pronew_add',$data)->render();
    }
    public function save(Request $r)
    {
        $inputs = $r->except('_token');
        $rules = [
                    'pronew_name' => 'required|max:100',
                    'pronew_properties' => 'required',                ];
        $message = [
                        'pronew_name.required' => 'Please Fill up this field it is required',
                        'pronew_properties.required' => 'Please Fill up this field it is required',
                        'pronew_name.max' => 'You Have Exceeded the maximum characters allowed( 100 characters)'

                    ];
        $validator = Validator::make($inputs,$rules,$message);
        if (!$validator->fails()) {
            if(isset($inputs['pronew_id'])){
                if(Promonewproject::where('pronew_id',$inputs['pronew_id'])->update($inputs)){
                    Session::flash('success','Promo New Project Updated Successfuly');
                        return redirect('admin/pronew');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again');
                        $r->flash();
                        return View::make('admin.pronew_add');
                    }

            }else{
                $inputs['pronew_slug'] = date_timestamp_get(date_create()) . rand(000000,999999);
                    if (Promonewproject::insert($inputs)) {

                        Session::flash('success','Promo/ New Project Added Successfuly');
                        return redirect('admin/pronew');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again. If you did not change anyting this error will pop up please check your inputs');
                        $r->flash();
                        return View::make('admin.pronew_add');
                    }
            }
        }else{
            $r->flash();
            return View::make('admin.pronew_add')->withErrors($validator);
        }
        
    }
    public function delete($id)
    {
        if (Promonewproject::where('pronew_id',$id)->update(['pronew_status'=>'4'])) {
            Session::flash('success', 'Promo/ New Project Deleted Successfully'); 
            return redirect('/admin/pronew');
        }else{
            Session::flash('success', 'There was an error in deleting the Promo/ New Project. If this persist again please contact your it personel'); 
            return redirect('/admin/pronew');
        }
        
    }
    public function finish($id)
    {
        if (Promonewproject::where('pronew_id',$id)->update(['pronew_status'=>'3'])) {
            Session::flash('success', 'Promo/ New Project Updated Successfully'); 
            return redirect('/admin/pronew');
        }else{
            Session::flash('success', 'There was an error in Updated the Promo/ New Project. If this persist again please contact your it personel'); 
            return redirect('/admin/pronew');
        }
        
    }

    public function fetch(Property $prop,SpecialProperty $sprop){
        $Prop = $prop->where('prop_status',1)->get(['prop_developer','prop_name','prop_slug','prop_price','prop_bed']);
        // $SProp = $sprop->where('sprop_status',1)->get(['sprop_dev as prop_developer','sprop_name as prop_name','sprop_slug as prop_slug']);
        $html = '<table class="table table-hover table-responsive" data-click-to-select="true" data-maintain-selected="true" data-pagination-v-align="top" data-pagination="true" data-search="true" data-sort-name="id" data-page-list="[10,25,50,100,all]" data-sort-order="desc" data-toggle="table">';
        $html .= '    <thead>';
        $html .= '        <tr>';
        $html .= '            <th data-radio="true"></th>';
        $html .= '            <th data-field="id" data-sortable="true">Name</th>';
        $html .= '            <th data-field="dev" data-sortable="true">Developer</th>';
        $html .= '            <th data-field="bed" data-sortable="true">Bed</th>';
        $html .= '            <th data-field="price" data-sortable="true">Price</th>';
        $html .= '        </tr>';
        $html .= '    </thead>';
        $html .= '    <tbody>';
        // foreach ($SProp as $key => $value) {
        //     $value->prop_dev = Developer::where('dev_id',$value->prop_developer)->pluck('dev_name')->first();
        //     $html .= '        <tr data-val="'.$value->prop_slug.'">';
        //     $html .= '            <td></td>';
        //     $html .= '            <td><label for="'.$value->prop_slug.'">'. $value->prop_name .'</label></td>';
        //     $html .= '            <td><label for="'.$value->prop_slug.'">'. $value->prop_dev .'</label></td>';
        //     $html .= '        </tr>';
        // }
        foreach ($Prop as $key => $value) {
            $value->prop_dev = Developer::where('dev_id',$value->prop_developer)->pluck('dev_name')->first();
            $html .= '        <tr data-val="'.$value->prop_slug.'">';
            $html .= '            <td></td>';
            $html .= '            <td><label for="'.$value->prop_slug.'">'. $value->prop_name .'</label></td>';
            $html .= '            <td><label for="'.$value->prop_slug.'">'. $value->prop_dev .'</label></td>';
            $html .= '            <td><label for="'.$value->prop_slug.'">'. $value->prop_bed .'</label></td>';
            $html .= '            <td><label for="'.$value->prop_slug.'">'. preg_replace('/\B(?=(\d{3})+(?!\d))/', ",", $value->prop_price) .'</label></td>';
            $html .= '        </tr>';
        }
        $html .= '    </tbody>';
        $html .= '</table>';

        return $html;
    }
    // public function view(Property $prop, Promonewproject $pronew, $id,$preview=null)
    // {
    //     if ($pronew->isActive($id) || !is_null($preview)) {
    //         if($data['pronew'] = $pronew->getBySlug($id)){
    //             $props = [];
    //             $prop_ids = explode(',', $data['pronew']->pronew_properties);
    //             $data['pronew']->type = $data['pronew']->pronew_type == 1 ? 'New Launch Project' : 'Promo' ;
    //             $data['pronew']->img = GalleryImage::where('img_id', $data['pronew']->pronew_bg)->pluck('img_path')->first();
    //             $data['pronew']->logo = GalleryImage::where('img_id', $data['pronew']->pronew_image)->pluck('img_path')->first();
    //             $data['pronew']->pronew_dev = Developer::where('dev_id',$data['pronew']->pronew_dev)->pluck('dev_name')->first();
    //             for ($i=0; $i < sizeof($prop_ids)-1; $i++) { 
    //                 $prop_details = $prop->where('prop_code',$prop_ids[$i])->first();
    //                 $prop_details->prop_loc = Location::where('loc_id',$prop_details->prop_location)->pluck('loc_name')->first();
    //                 $prop_details->prop_dev = Developer::where('dev_id',$prop_details->prop_developer)->pluck('dev_name')->first();
    //                 $img = GalleryImage::where('img_id',$prop_details->prop_featured_image)->pluck('img_path')->first();
    //                 $parths = explode('/', $img);
    //                 if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
    //                     $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
    //                 }else{
    //                     $thumb_file = $img;
    //                 }
    //                 $prop_details->prop_img = $thumb_file;
    //                 $props[] = $prop_details;
    //             }
    //             $data['pronew']->props = $props;
    //             return View::make('properties.pronew',$data);    
    //         }else{
    //             return View::make('errors.404');
    //         }
    //     }else{
    //         return View::make('errors.404');
    //     }
    // }
    function featsave(Request $r){
        $inputs = $r->except('_token');
        $idarr = explode(',', $inputs['propfeat']);
        if (sizeof($idarr) < 1) {
            $r->flash();
            Session::flash('message','Please Select 1 or more Promo / New Project to feature.');
        }else{
            $r->flash();
            $feats = Featured::where('feat_type','1')->first();
            if($feats){
                if($feats->where('feat_type',1)->update($inputs)){
                    Session::flash('message','Featured Properties Saved Successfuly');
                }else{
                    Session::flash('message','Oops Something went wrong. Please contact your IT personel');
                }
            }else{
                if(Featured::insert($inputs)){
                    Session::flash('message','Featured Properties Saved Successfuly');
                }else{
                    Session::flash('message','Oops Something went wrong. Please contact your IT personel');
                }
            }
        }
        return redirect('admin/featprom');
    }
    function feat(){
        $prop = Promonewproject::whereIn('pronew_status',[1])->get();
        $data['feat'] = Featured::where('feat_type',1)->first();        
        
        for ($i=0; $i < sizeof($prop); $i++) {
            $data['prop'][$i]['id'] = $prop[$i]->pronew_slug;
            $data['prop'][$i]['name'] = $prop[$i]->pronew_name;
            $data['prop'][$i]['type'] = $prop[$i]->pronew_type == 1 ? 'New Project': 'Promo';
        }
        return view('admin.featprom',$data);
    }

}