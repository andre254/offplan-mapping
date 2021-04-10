<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Models\Author;
use App\User;
use App\Models\Blog;
use View;
use Validator;
use Form;
use Input;
use Session;

class AuthorController extends Controller
{
    public function index()
    {
        return view::make('admin.author_add')->render();
    }

    public function save(Request $r)
    {
        $inputs = $r->except('_token');
        $rules = [
                    'author_fname' => 'required|max:100',
                    'author_lname' => 'required|max:100',
                    'author_email' => 'required|max:50',
                ];
        $message = [
                        'author_fname.required' => 'Please Fill up this field it is required',
                        'author_lname.required' => 'Please Fill up this field it is required',
                        'author_email.required' => 'Please Fill up this field it is required',
                        'author_fname.max' => 'You have exceeded the maximum character count(100)',
                        'author_lname.max' => 'You have exceeded the maximum character count(100)',
                        'author_email.max' => 'You have exceeded the maximum character count(50)',

                    ];
        $validator = Validator::make($inputs,$rules,$message);
        if (!$validator->fails()) {
            if(isset($inputs['author_id'])){
                if(Author::where('author_id',$inputs['author_id'])->update($inputs)){
                    Session::flash('success','Author Updated Successfuly');
                        return redirect('admin/authors');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again');
                        $r->flash();
                        return View::make('admin.author_add');
                    }

            }else{
                $inputs['author_slug'] = preg_replace('/[\s]+/','',($inputs['author_fname'] .'-'. $inputs['author_lname'])) . rand(000000,999999);
                    if (Author::insert($inputs)) {
                        User::insert(['name'=>$inputs['author_fname'],'email'=>$inputs['author_email'],'password'=>bcrypt($inputs['author_lname'] . $inputs['author_fname']),'level'=>3]);
                        Session::flash('success','Author Added Successfuly');
                        return redirect('admin/authors');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again. If you did not change anyting this error will pop up please check your inputs');
                        $r->flash();
                        return View::make('admin.author_add');
                    }
            }
        }else{
            $r->flash();
            return View::make('admin.author_add')->withErrors($validator);
        }
    }
    public function edit($id)
    {
        $data['data'] = Author::where('author_id',$id)->first(); 
        return View::make('admin.author_add',$data)->render();
    }
    public function view(Author $prop, $id)
    {   
        $data['data'] = $prop->where('author_slug',$id)->first();
        if ($data['data']) {
            $data['data']->author_img = GalleryImage::where('img_id',$data['data']->author_img)->pluck('img_path')->first();
            $data['articles'] = Blog::where('blog_author',$data['data']->author_id)->where('blog_status',1)->paginate(9);
            foreach ($data['articles'] as $key => $value) {
                $data['articles'][$key]->blog_img = GalleryImage::where('img_id',$data['articles'][$key]->blog_img)->pluck('img_path')->first();
            }
            return View::make('blog.author_page',$data);
        }else{
            return View::make('errors.404');
        }
    }

    public function delete($id)
    {
        Author::where('author_id',$id)->delete();
        Session::flash('success','Author Deleted Successfuly');
        return redirect('admin/authors');
    }
}
