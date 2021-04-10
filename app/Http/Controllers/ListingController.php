<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyListing;
use View;
use Session;

class ListingController extends Controller
{
    public function view($id){
        $data['listing'] = PropertyListing::where('list_id',$id)->first(); 
        return View::make('admin.listing_add',$data)->render();
    }
    public function delete($id)
    {
        PropertyListing::where('list_id',$id)->update(['list_status'=>4]);
        Session::flash('success','Property Listing Request Deleted Successfuly');
        return redirect('admin/listing');
    }
    public function reject($id)
    {
        PropertyListing::where('list_id',$id)->update(['list_status'=>5]);
        Session::flash('success','Property Listing Request Rejected Successfuly');
        return redirect('admin/listing');
    }
    public function aprove($id)
    {
        $data['data'] = PropertyListing::where('list_id',$id)->first();
        return View::make('admin.prop_add',$data)->render();
    }
}
