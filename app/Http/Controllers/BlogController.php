<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Location;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Author;
use App\Models\Tag;
use App\Models\TagsBlog;
use App\Models\File;
use View;
use Validator;
use Form;
use Input;
use Session;

class BlogController extends Controller
{
    public function index()
    {
        return view::make('admin.blog_add')->render();
    }

    public function save(Request $r)
    {
        $inputs = $r->except(['_token','blog_meta_keys']);
        $rules = [
                    'blog_title' =>'required|max:100',
                    'blog_slug' =>'required|max:100',
                    'blog_content' =>'required',
                    'blog_img' =>'required',
                    'blog_status' =>'required',
                    'blog_author' =>'required'
                ];
        $message = [
                    'blog_title.required'=>'Please Fill Up this Field it is required',
                    'blog_slug.required'=>'Please Fill Up this Field it is required',
                    'blog_content.required'=>'Please Fill Up this Field it is required',
                    'blog_img.required'=>'Please Fill Up this Field it is required',
                    'blog_status.required'=>'Please Fill Up this Field it is required',
                    'blog_meta_key.required'=>'Please Fill Up this Field it is required',
                    'blog_meta_desc.required'=>'Please Fill Up this Field it is required',
                    'blog_author.required'=>'Please Fill Up this Field it is required',
                    'blog_title.max'=>'You have Exceeded The Maximum Characters Allowed(100)',
                    'blog_slug.max'=>'You have Exceeded The Maximum Characters Allowed(100)'

                    ];
        $validator = Validator::make($inputs,$rules,$message);
        if (!$validator->fails()) {
            if(isset($inputs['blog_id'])){
                if(Blog::where('blog_id',$inputs['blog_id'])->update($inputs)){
                    TagsBlog::where('blog_id',$inputs['blog_id'])->delete();
                        $tags = strpos($inputs['blog_meta_key'],',');
                        if ($tags) {
                            foreach (explode(',',$inputs['blog_meta_key']) as $key => $value) {
                                $teghi = Tag::firstOrCreate(['tag_name'=>$value]);
                                $tagpr = TagsBlog::updateOrCreate(['tags_id'=>$teghi->tags_id,'blog_id'=>$inputs['blog_id']]);
                            }
                        }else{
                            $teghi = Tag::firstOrCreate(['tag_name'=>$tags]);
                            $tagpr = TagsBlog::updateOrCreate(['tags_id'=>$teghi->tags_id,'blog_id'=>$inputs['blog_id']]);
                        }
                        Session::flash('success','Blog Updated Successfuly');
                        return redirect('admin/blog');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again');
                        $r->flash();
                        return View::make('admin.blog_add');
                    }

            }else{
                $inputs['blog_slug'] = $inputs['blog_slug'] . rand(000000,999999);
                $res_blog = Blog::insert($inputs);
                    if ($res_blog) {
                        $tags = strpos($inputs['blog_meta_key'],',');
                        if ($tags) {
                            foreach (explode(',',$inputs['blog_meta_key']) as $key => $value) {
                                $teghi = Tag::firstOrCreate(['tag_name'=>$value]);
                                $tagpr = TagsBlog::updateOrCreate(['tags_id'=>$teghi->tags_id,'prop_id'=>$res_blog->blog_id]);
                            }
                        }else{
                             $teghi = Tag::firstOrCreate(['tag_name'=>$tags]);
                                $tagpr = TagsBlog::updateOrCreate(['tags_id'=>$teghi->tags_id,'blog_id'=>$inputs['blog_id']]);
                        }
                        Session::flash('success','Blog Added Successfuly');
                        return redirect('admin/blog');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again. If you did not change anyting this error will pop up please check your inputs');
                        $r->flash();
                        return View::make('admin.blog_add');
                    }
            }
        }else{
            if(isset($inputs['blog_id'])){
                 $r->flash();
                return View::make('admin.blog_add')->withErrors($validator)->render();
            }else{
                $inputs['blog_status'] = 2;
                $inputs['blog_slug'] = '';
                    if (Blog::insert($inputs)) {
                        Session::flash('success','Blog Added Successfuly(Saved As Draft)');
                        return redirect('admin/blog');
                    }else{
                        Session::flash('success','Something Went Wrong Please Try Again. If you did not change anyting this error will pop up please check your inputs');
                        $r->flash();
                        return View::make('admin.blog_add');
                    }
            }
        }
    }
    public function edit($id)
    {
        $data['data'] = Blog::where('blog_id',$id)->first(); 

        return View::make('admin.blog_add',$data)->render();
    }
    public function view(Blog $blog, $id,$preview=null)
    {
        $data['data'] = $blog->where('blog_slug',$id)
                            ->leftJoin('gallery_images','gallery_images.img_id','blog.blog_img')
                            ->leftJoin('author','author.author_id','blog.blog_author')
                            ->select('gallery_images.img_path','blog.*','author.*')
                            ->first();

        if ($data['data']) {
            $data['data']->blog_img = $data['data']->img_path;
            $data['data']->blog_content = preg_replace('/(<img[^>]*src=")([^"]*)("[^>]*>)/i', '$1$2" class="mw-100 m-auto$3' ,  $data['data']->blog_content);

            return View::make('blog.page',$data);
        }else{
            return View::make('errors.404');
        }
    }

    public function delete($id)
    {
        Blog::where('blog_id',$id)->update(['blog_status'=>3]);
        Session::flash('success','Blog Deleted Successfuly');
        return redirect('admin/blog');
    }
}
