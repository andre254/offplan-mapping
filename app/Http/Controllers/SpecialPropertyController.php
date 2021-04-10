<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialProperty;
use App\Models\Property;
use App\Models\Developer;
use App\Models\GalleryImage;
use App\Models\Location;
use Propaganistas\LaravelIntl\Facades\Country;
use \Carbon\Carbon;
use View;
use Validator;
use Session;

class SpecialPropertyController extends Controller
{
    public function index(){

        return view::make('admin.sprop_add')->render();
    }
    public function edit($id)
    {
        $data['data'] = SpecialProperty::find($id);
        return View::make('admin.sprop_add',$data)->render();
    }
    public function save(Request $r)
    {
        $inputs = $r->except('_token');
        $rules = [
                    'sprop_name' => 'required|max:100',
                    'sprop_properties' => 'required'];
        $message = [
                        'sprop_name.required' => 'Please Fill up this field it is required',
                        'sprop_properties.required' => 'Please Fill up this field it is required',
                        'sprop_name.max' => 'You Have Exceeded the maximum characters allowed( 100 characters)'

                    ];
        $validator = Validator::make($inputs,$rules,$message);
        if (!$validator->fails()) {
            if(isset($inputs['sprop_id'])){
                if(SpecialProperty::where('sprop_id',$inputs['sprop_id'])->update($inputs)){
                    Session::flash('success','SpecialProperty Updated Successfuly');
                        return redirect('admin/sprop');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again');
                        $r->flash();
                        return View::make('admin.sprop_add');
                    }

            }else{
                $inputs['sprop_slug'] = $inputs['sprop_slug'];
                    if (SpecialProperty::insert($inputs)) {

                        Session::flash('success','Community Added Successfuly');
                        return redirect('admin/sprop');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again. If you did not change anyting this error will pop up please check your inputs');
                        $r->flash();
                        return View::make('admin.sprop_add');
                    }
            }
        }else{
            $r->flash();
            return View::make('admin.sprop_add')->withErrors($validator);
        }
        
    }
    public function delete($id)
    {
        if (SpecialProperty::where('sprop_id',$id)->update(['sprop_status'=>'4'])) {
            Session::flash('success', 'SpecialProperty Deleted Successfully'); 
            return redirect('/admin/sprop');
        }else{
            Session::flash('success', 'There was an error in deleting the Community. If this persist again please contact your it personel'); 
            return redirect('/admin/sprop');
        }
        
    }
    public function fetch(Property $prop){
        $Property = $prop->where('prop_status',1)->get();
        $html = '<table class="table table-hover table-responsive" data-click-to-select="true" data-maintain-selected="true" data-pagination-v-align="top" data-pagination="true" data-search="true" data-sort-name="id" data-page-list="[10,25,50,100,all]" data-sort-order="desc" data-toggle="table">';
        $html .= '    <thead>';
        $html .= '        <tr>';
        $html .= '            <th data-checkbox="true"></th>';
        $html .= '            <th data-field="id" data-sortable="true">ID</th>';
        $html .= '            <th data-field="dev" data-sortable="true">Developer</th>';
        $html .= '            <th data-field="name" data-sortable="true">Project Name</th>';
        $html .= '        </tr>';
        $html .= '    </thead>';
        $html .= '    <tbody>';
        foreach ($Property as $key => $value) {
            $value->prop_dev = Developer::where('dev_id',$value->prop_developer)->pluck('dev_name')->first();
            $html .= '        <tr data-val="'.$value->prop_code.'">';
            $html .= '            <td></td>';
            $html .= '            <td><label for="'.$value->prop_code.'">'. $value->prop_code .'</label></td>';
            $html .= '            <td><label for="'.$value->prop_code.'">'. $value->prop_dev .'</label></td>';
            $html .= '            <td><label for="'.$value->prop_code.'">'. $value->prop_name .'</label></td>';
            $html .= '        </tr>';
        }
        $html .= '    </tbody>';
        $html .= '</table>';

        return $html;
    }
    public function list(SpecialProperty $sprop){
        $sprop = $sprop->leftJoin('gallery_images','gallery_images.img_id','=','special_property.sprop_image')
                       ->select('gallery_images.img_path','special_property.sprop_name','special_property.sprop_description','special_property.sprop_slug')
                       ->paginate(8);
        foreach ($sprop as $key => $value) {
            $img = $sprop[$key]->img_path;
                $parths = explode('/', $img);
                if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                    $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                }else{
                    $thumb_file = $img;
            }
            $dirs[$key]['name'] = $sprop[$key]->sprop_name;
            $dirs[$key]['img'] = $thumb_file;
            $dirs[$key]['slug'] = 'community/'.$sprop[$key]->sprop_slug;
            $dirs[$key]['blurb'] = $sprop[$key]->sprop_description;
        }
        $data['country'] = Country::all();
        $data['dirs'] = $dirs;
        $data['pags'] = $sprop;
        $data['sec'] = 'Communities';
        
        return View::make('properties.dev_com',$data)->render();

    }
    public function view(Property $prop, SpecialProperty $sprop,Carbon $c, $id,$preview=null)
    {
        $data['sprop'] = $sprop->leftJoin('gallery_images','gallery_images.img_id','=','special_property.sprop_bg')
                               ->leftJoin('developer','developer.dev_id','=','special_property.sprop_dev')
                               ->select('special_property.*',\DB::raw('(SELECT img_path FROM gallery_images WHERE img_id = special_property.sprop_image) as com_img'),'gallery_images.img_path as bg_img','developer.dev_name','developer.dev_slug')
                               ->where('sprop_slug',$id)
                               ->first();
        $data['sprop']->img = $data['sprop']->bg_img;
        $data['sprop']->logo = $data['sprop']->com_img;
        $data['sprop']->sprop_dev = $data['sprop']->dev_name;
        $prop_details = $prop->leftJoin('location','location.loc_id','=','property.prop_location')
                             ->leftJoin('developer','developer.dev_id','=','property.prop_developer')
                             ->leftJoin('gallery_images','gallery_images.img_id','=','property.prop_featured_image')
                             ->leftJoin('gallery_images as dev_img','dev_img.img_id','=','developer.dev_image')
                             ->select('gallery_images.img_path','location.loc_name','developer.dev_name','property.prop_name','property.prop_developer','property.prop_type','property.prop_date_fin','property.prop_date_null','property.prop_code','property.prop_area','property.prop_slug','property.prop_bed','property.prop_price','dev_img.img_path as dev_img')
                             ->where('prop_community',$data['sprop']->sprop_id)
                             ->where('prop_status','1')
                             ->paginate(8);
        foreach ($prop_details as $key => $value) {
            if (!$prop_details[$key]->prop_date_null) {
                $date = $c->createFromFormat('Y-m-d H:i:s', $prop_details[$key]->prop_date_fin);
                $prop_details[$key]->finished = ($c->now()->diffInDays($date,false) <= 0) ? 1 : 0;
                $date = $c->parse($date);
                $prop_details[$key]->date_fin = 'Q' . $date->quarter . ' ' . $date->year;
            }

            $img = $prop_details[$key]->img_path;
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
            $d_img = $prop_details[$key]->dev_img;
            $d_parths = explode('/', $d_img);
            $d_thumb_file = $img;
            if(file_exists($d_parths[0] . '/tiny/' . $d_parths[1])){
                    $d_thumb_file = $d_parths[0] . '/tiny/' . $d_parths[1];
            }
            $prop_details[$key]->prop_img = $thumb_file;
            $prop_details[$key]->dev_img = $d_thumb_file;
            $prop_details[$key]->prop_loc = $value->loc_name;
            $prop_details[$key]->prop_dev = $value->dev_name;
        }
        $data['li'] = $id;
        $data['country'] = Country::all();
        $data['sprop']->props = $prop_details;
        return View::make('properties.special_prop',$data);    
   
    }

}