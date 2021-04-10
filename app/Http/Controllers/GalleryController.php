<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use View;
use Validator;
use Form;
use Input;
use Session;

class GalleryController extends Controller
{
    public function index(){

        return view::make('admin.gal_add')->render();
    }
    public function edit($id)
    {
        $data['data'] = Gallery::find($id);
        return View::make('admin.gal_add',$data)->render();
    }
    public function save(Request $r, Gallery $gal)
    {
        $inputs = $r->all();
        $rules = [
            'gal_name' => 'required|max:150',
            'gal_image' => 'required'
        ];
        $message = [
            'gal_name.required' => 'Please Enter Gallery Name',
            'gal_name.max' => 'You have exceeded the maximum characters allowed',
            'gal_image.required' => 'Please Select Images for the Gallery',
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if(!$validator->fails()){
            if (isset($inputs['gal_id'])) {
                $upgal = $gal->find($inputs['gal_id']);
                $upgal->gal_name = $inputs['gal_name'];
                $upgal->gal_image_ids = $inputs['gal_image'];
                $upgal->gal_desc = $inputs['gal_desc'];
                $result = $upgal->save();
            }else{
                $gal->gal_name = $inputs['gal_name'];
                $gal->gal_image_ids = $inputs['gal_image'];
                $gal->gal_desc = $inputs['gal_desc'];
                $result = $gal->save();
            }
            
            if($result){
                if (isset($inputs['gal_id'])) {
                    Session::flash('success', 'Gallery Updated Successfully'); 
                }else{
                    Session::flash('success', 'Gallery Added Successfully'); 
                }
                return redirect('/admin/gal');
            }else{
                Session::flash('success', 'There was an error. If this persist again please contact your it personel'); 
                return redirect('/admin/gal');
            }
            
        }else{
            $r->flash();
            return view('admin.gal_add')->withErrors($validator)->render();
        }
        
    }
    public function getImgIds($id){
        $getImgIds = Gallery::where('gal_id',$id)->first()->toArray();
        return json_encode($getImgIds);
    }
    public function delete($id)
    {
        if (Gallery::find($id)->delete()) {
            Session::flash('success', 'Gallery Deleted Successfully'); 
            return redirect('/admin/gal');
        }else{
            Session::flash('success', 'There was an error in deleting the gallery. If this persist again please contact your it personel'); 
            return redirect('/admin/gal');
        }
        
    }
    public function fetch(Gallery $gal){
        $gallery = $gal->all();
        $html = '<table class="table table-hover table-responsive"  data-pagination-v-align="top" data-pagination="true" data-search="true" data-sort-name="id" data-sort-order="desc" data-toggle="table">';
        $html .= '    <thead>';
        $html .= '        <tr>';
        $html .= '            <th></td>';
        $html .= '            <th data-field="id" data-sortable="true">ID</td>';
        $html .= '            <th data-field="name" data-sortable="true">Name</td>';
        $html .= '        </tr>';
        $html .= '    </thead>';
        $html .= '    <tfoot>';
        $html .= '        <tr>';
        $html .= '            <td></td>';
        $html .= '            <td data-field="id" data-sortable="true">ID</td>';
        $html .= '            <td data-field="name" data-sortable="true">Name</td>';
        $html .= '        </tr>';
        $html .= '    </tfoot>';
        $html .= '    <tbody>';
        foreach ($gallery as $key => $value) {
            $html .= '        <tr>';
            $html .= '            <td><input type="radio" name="gal_mod_id" value="'.$value->gal_id.'" id="'.$value->gal_id.'"></td>';
            $html .= '            <td><label for="'.$value->gal_id.'">'. $value->gal_id .'</label></td>';
            $html .= '            <td><label for="'.$value->gal_id.'">'. $value->gal_name .'</label></td>';
            $html .= '        </tr>';
        }
        $html .= '    </tbody>';
        $html .= '</table>';

        return $html;
    }
}