<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Developer;
use App\Models\Property;
use App\Models\SpecialProperty;
use App\Models\Location;
use App\Models\Blog;

class SitemapController extends Controller
{
    public function index()
    {
      $data['prop'] = Property::where('prop_status',1)->orderBy('prop_date_up', 'desc')->get();
      $data['blog'] = Blog::where('blog_status',1)->orderBy('blog_date_up', 'desc')->get();
      $data['sprop'] = SpecialProperty::where('sprop_status',1)->orderBy('sprop_date_up', 'desc')->get();
      // $data['loc'] = Location::orderBy('loc_date_up', 'desc')->get();
      $data['dev'] = Developer::orderBy('dev_date_up', 'desc')->get();
    
      return response()->view('sitemap.index', $data)->header('Content-Type', 'text/xml');
    }
}
