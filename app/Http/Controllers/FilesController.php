<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use View;
use Validator;
use Session;

class FilesController extends Controller
{
    public function index(){
        return view::make('admin.files_add')->render();
    }
    public function save(Request $r,File $gi)
    {
        $inputs = $r->except('_token');
        $rules = [
                'file_name' => 'required|max:150'
            ];
        $message = [
                'file_name.required' => 'Please Enter File Name',
                'file_name.max' => 'You have exceeded the maximum characters allowed(150)'
            ];
        $validator = Validator::make($inputs,$rules,$message);
        if (!$validator->fails()) { 
            if(isset($inputs['file_id'])){
                if(File::where('file_id',$inputs['file_id'])->update($inputs)){
                    Session::flash('success', 'File Updated Successfully'); 
                    return redirect('/admin/files');
                }else{
                    Session::flash('success', 'There was an error in updating the File please try again. If this problem persist again please contact your IT personel');
                    return redirect('/admin/files');
                }
            }else{
                if($gi->insert($inputs)){
                    Session::flash('success', 'File Uploaded Successfully'); 
                    return redirect('/admin/files/add');
                }else{
                    Session::flash('success', 'File Not inserted please try again.');
                    return redirect('/admin/files/add');
                }
            }
        }
    }
    public function edit($id)
    {
        $data['data'] = File::find($id);
        return View::make('admin.files_add',$data)->render();
    }
    public function remove(Request $r)
    {
        $id = $r->all();
        if (unlink($id['id'])) {
            return json_encode(['status'=>'success']);
        }
    }
    public function fetch(File $gi,$type = null){
        $files = $gi->all();
        $html = '<table class="table table-hover table-responsive"  data-pagination-v-align="top" data-pagination="true" data-search="true" data-sort-name="id" data-sort-order="desc" data-toggle="table">';
        $html .= '    <thead>';
        $html .= '        <tr>';
        $html .= '            <th></td>';
        $html .= '            <th data-field="id" data-sortable="true">ID</td>';
        $html .= '            <th data-field="name" data-sortable="true">Path</td>';
        $html .= '        </tr>';
        $html .= '    </thead>';
        $html .= '    <tfoot>';
        $html .= '        <tr>';
        $html .= '            <td></td>';
        $html .= '            <td data-field="id" data-sortable="true">ID</td>';
        $html .= '            <td data-field="name" data-sortable="true">Path</td>';
        $html .= '        </tr>';
        $html .= '    </tfoot>';
        $html .= '    <tbody>';
        foreach ($files as $key => $value) {
            $html .= '        <tr>';
            $html .= '            <td><input type="checkbox" name="file_mod_id[]" value="'.$value->file_id.'" id="'.$value->file_id.'"></td>';
            $html .= '            <td><label for="'.$value->file_id.'">'. $value->file_id .'</label></td>';
            $html .= '            <td><label for="'.$value->file_id.'">'. $value->file_path .'</label></td>';
            $html .= '        </tr>';
        }
        $html .= '    </tbody>';
        $html .= '</table>';

        return $html;
    }
    public function delete(Request $r,File $gi,$id)
    {
        if ($gi->where('file_id',$id)->delete()) {
            Session::flash('success','File Deleted');
            return redirect('admin/files');
        }else{
            Session::flash('success','Something went wrong Please Try again');
            return redirect('admin/files');
        }
        
    }
}