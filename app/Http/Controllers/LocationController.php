<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use View;
use Validator;
use Form;
use Input;
use Session;

class LocationController extends Controller
{
    public function index(){
        return view::make('admin.loc_add')->render();
    }
    public function edit($id)
    {
        $data['data'] = Location::find($id);
        return View::make('admin.loc_add',$data)->render();
    }
    public function save(Request $r, Location $loc)
    {
        $inputs = $r->all();
        $rules = [
            'loc_name' => 'required|max:150',
        ];
        $message = [
            'loc_name.required' => 'Please Enter Location Name',
            'loc_name.max' => 'You have exceeded the maximum characters allowed',
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if(!$validator->fails()){
            if (isset($inputs['loc_id'])) {
                $uploc = $loc->find($inputs['loc_id']);
                $uploc->loc_name = $inputs['loc_name'];
                $uploc->loc_slug = $inputs['loc_slug'];
                $uploc->loc_desc = $inputs['loc_desc'];
                $uploc->loc_img = $inputs['loc_image'];
                $result = $uploc->save();
            }else{
                $loc->loc_name = $inputs['loc_name'];
                $loc->loc_slug = $inputs['loc_slug'];
                $loc->loc_desc = $inputs['loc_desc'];
                $loc->loc_img = $inputs['loc_image'];
                $result = $loc->save();
            }
            
            if($result){
                if (isset($inputs['loc_id'])) {
                    Session::flash('success', 'Location Updated Successfully'); 
                }else{
                    Session::flash('success', 'Location Added Successfully'); 
                }
                return redirect('/admin/loc');
            }else{
                Session::flash('success', 'There was an error. If this persist again please contact your it personel'); 
                return redirect('/admin/loc');
            }
            
        }else{
            $r->flash();
            return view('admin.loc_add')->withErrors($validator)->render();
        }
    }
    
    public function delete($id)
    {
        if (Location::find($id)->delete()) {
            Session::flash('success', 'Location Deleted Successfully'); 
            return redirect('/admin/loc');
        }else{
            Session::flash('success', 'There was an error in deleting the location. If this persist again please contact your IT personel'); 
            return redirect('/admin/loc');
        }
    }

}
