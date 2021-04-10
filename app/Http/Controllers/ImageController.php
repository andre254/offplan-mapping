<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use View;
use Validator;
use Session;
use Image;

class ImageController extends Controller
{
    public function index(GalleryImage $gi){
        return view::make('admin.img_add')->render();
    }

    public function upload(Request $r)
    {
        if ($r->hasFile('image_up')) {
            $inputs = $r->file('image_up');
            foreach($inputs as $files){
                $date = date_timestamp_get(date_create());
                $filename = $files->getClientOriginalName();
                $extension = $files->getClientOriginalExtension();
                $filename = str_replace('.'.$extension, '', $filename);
                $picture = $date.'-'.rand(00000,99999) .'.'. $extension;
                $destinationPath = 'uploads';
                $image = Image::make($files->getRealPath())->interlace();
                $mainImage = $image->save($destinationPath.'/'.$picture,85);
                $thumb = $image->resize(384, 250, function ($constraint) {
                    $constraint->aspectRatio(); //maintain image ratio
                })->save($destinationPath.'/thumbs/'.$picture);
                $thumb_desk = $image->resize(547, 315, function ($constraint) {
                    $constraint->aspectRatio(); //maintain image ratio
                })->save($destinationPath.'/thumbs_desk/'.$picture);
                $tiny = $image->resize(100, 53, function ($constraint) {
                    $constraint->aspectRatio(); //maintain image ratio
                })->save($destinationPath.'/tiny/'.$picture);
                $paths['items'][] = array(
                        'img_tmp_path' => $destinationPath.'/'.$picture,
                        'img_name' => $filename,
                        'img_real_name' => $picture
                    );
            }
            $paths['count'] = sizeof($inputs);
            return json_encode($paths);
        }
    }
    public function save(Request $r,GalleryImage $gi)
    {
        $inputs = $r->all();
        for ($i=0; $i < $inputs['count']; $i++) { 
            $data[] = [
                'img_name'=>$inputs['img_name'][$i],
                'img_file_name'=>$inputs['img_file_name'][$i],
                'img_desc'=>$inputs['img_desc'][$i],
                'img_path'=>$inputs['img_path'][$i]
                ];
        }
        if($gi->insert($data)){
            Session::flash('success', 'Image Uploaded Successfully'); 
            return redirect('/admin/imgup');
        }else{
            for ($i=0; $i < $inputs['count']; $i++) { 
                unlink($inputs['img_path'][$i]);
            }
            Session::flash('success', 'Image Not inserted please try again.');
            return redirect('/admin/imgup');
        }
    }
    public function update(Request $r,GalleryImage $gi)
    {
        $inputs = $r->all();
        $rules = [
                'img_name' => 'required|max:150'
            ];
        $message = [
                'img_name.required' => 'Please Enter Image Name',
                'img_name.max' => 'You have exceeded the maximum characters allowed(150)'
            ];
        $validator = Validator::make($inputs,$rules,$message);
        if (!$validator->fails()) { 
            $giu = $gi->find($inputs['img_id']);
            $giu->img_name = $inputs['img_name'];
            $giu->img_desc = $inputs['img_desc'];
            
            if($giu->save()){
                Session::flash('success', 'Image Updated Successfully'); 
                return redirect('/admin/imgup');
            }else{
                Session::flash('success', 'There was an error in updating the image please try again. If this problem persist again please contact your IT personel');
                return redirect('/admin/imgup');
            }
        }else{
            $r->flash();
            return view('admin.img_edit')->withErrors($validator);
        }
    }
    public function edit($id)
    {
        $data['data'] = GalleryImage::find($id);
        return View::make('admin.img_edit',$data)->render();
    }
    public function remove(Request $r)
    {
        $id = $r->all();
        $filename = $id['id'];
        $parts = explode('/',$id['id']);
        $thumb = $parts[0] . '/thumbs/' . $parts[1];
        $thumb_desk = $parts[0] . '/thumbs_desk/' . $parts[1];
        $tiny = $parts[0] . '/tiny/' . $parts[1];
        if (unlink($filename) && unlink($thumb)) {
            unlink($thumb_desk);
            unlink($tiny);
            return json_encode(['status'=>'success']);
        }
    }
    public function getimg(GalleryImage $gi,$type = null){
        $images = $gi->orderBy('img_uploaded','desc')->get()->toArray();
        $html = '';
        $html .= '<table class="table" data-pagination-v-align="top" data-maintain-selected="true" data-page-list="[10, 25, 50, 100, ALL]" data-pagination="true" data-search="true" data-sort-name="id" data-sort-order="desc" data-toggle="table">';
        $html .= '    <thead>';
        $html .= '        <tr>';
        $html .= '            <th data-field="id" data-sortable="true">Id</th>';
        $html .= '            <th data-field="name" data-sortable="true">Name</th>';
        $html .= '        </tr>';
        $html .= '    </thead>';
        $html .= '    <tbody>';
        foreach ($images as $key => $value) {
            $parths = explode('/', $value['img_path']);
            if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
            }else{
                $thumb_file = $value['img_path'];
            }
            if (is_null($type)) {
                $html .= '        <tr style="display:none;">';
                $html .= ' <td><input type="checkbox" name="checkbox[]" id="'.$value['img_id'].'" value="'.$value['img_id'].'" >'.$value['img_id'].'</td>';
                $html .= ' <td><label for="'.$value['img_id'].'"><img class="tile-img" src="'.asset($thumb_file).'" width="150" height="150" alt="" />'.$value['img_name'].'</label></td>';

                $html .= '        </tr>';
            }else{
                $html .= '        <tr style="display:none;">';
                $html .= ' <td><input type="radio" name="imgsel" id="'.$value['img_id'].'" value="'.$value['img_id'].'" >'.$value['img_id'].'</td>';
                $html .= '            <td><label for="'.$value['img_id'].'"><img class="tile-img" src="'.asset($thumb_file).'" width="150" height="150" alt="" />'.$value['img_name'].'</label></td>';
                $html .= '        </tr>';
            }
        }
        $html .= '    </tbody>';
        $html .= '</table>';
        return $html;
    }
    public function fetchimg($ids){
        $paths;
        $imageids = $ids;
        $imageids = explode(',', $imageids);
        if (sizeof($imageids)>1) {
            $img_paths = GalleryImage::whereIn('img_id',$imageids)->select('img_id','img_path')->get();
            foreach ($img_paths as $key => $value){ 
                $parths = explode('/', $value->img_path);
                if(file_exists($parths[0] . '/tiny/' . $parths[1])){
                    $thumb_file = $parths[0] . '/tiny/' . $parths[1];
                }else if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                    $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                }else{
                    $thumb_file = img_path;
                }
                $paths[] = [
                    'img_path' => $thumb_file,
                    'img_id' => $value->img_id
                ];
            }
        }else{
             $img_paths = GalleryImage::whereImgId($imageids)->select('img_path')->first();
             $parths = explode('/', $img_paths->img_path);
                if(file_exists($parths[0] . '/tiny/' . $parths[1])){
                    $thumb_file = $parths[0] . '/tiny/' . $parths[1];
                }else if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                    $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                }else{
                    $thumb_file = $img_paths->img_path;
                }
                $paths[0]['img_path'] = $thumb_file;
                $paths[0]['img_id'] = $imageids;
        }
        

        return json_encode($paths);
    }
    public function delete(Request $r,GalleryImage $gi,$id)
    {
        $img_id = $id;
        $imgpath = $gi->where('img_id',$img_id)->pluck('img_path')->toArray();
        $filename = $imgpath[0];
        $parts = explode('/',$imgpath[0]);
        $thumb = $parts[0] . '/thumbs/' . $parts[1];
        $tiny = $parts[0] . '/tiny/' . $parts[1];
        if (unlink($filename) || unlink($thumb) || unlink($tiny)) {
            $gi->where('img_id',$img_id)->delete();
        }
        Session::flash('success','Image Deleted');
        return redirect('admin/imgup');
    }
}
?>
