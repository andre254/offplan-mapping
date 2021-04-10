<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Session;

class TestimonyController extends Controller
{
    public function delete($id)
    {
        Testimonial::where('testimony_id',$id)->update(['testimony_status'=>4]);
        Session::flash('success','Testimonial Deleted Successfuly');
        return redirect('admin/testimonials');
    }
    public function reject($id)
    {
        Testimonial::where('testimony_id',$id)->update(['testimony_status'=>2]);
        Session::flash('success','Testimonial Rejected Successfuly');
        return redirect('admin/testimonials');
    }
    public function aprove($id)
    {
        Testimonial::where('testimony_id',$id)->update(['testimony_status'=>1]);
        Session::flash('success','Testimonial Approved Successfuly');
        return redirect('admin/testimonials');
    }
}
