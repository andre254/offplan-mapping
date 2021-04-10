<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Session;
use Validator;
use App\Models\Property;
use App\Models\SpecialProperty;
use App\Models\Featured;
use App\Models\Blog;
use App\Models\Author;
use App\Models\Developer;
use App\Models\Location;
use App\Models\GalleryImage;
use App\Models\Tags;
use App\Models\TagsBlog;
use App\Models\TagsProp;
use App\Models\Promonewproject;
use App\Models\Testimonial;
use Illuminate\Support\Carbon;
use Propaganistas\LaravelIntl\Facades\Country;

class SiteController extends Controller
{
    
    public function index()
    {   
        //latest properties data construction
        //property data construction
        $prop = Property::where('prop_status',1)
                ->join('gallery_images','gallery_images.img_id', '=', 'property.prop_featured_image')
                ->join('developer','developer.dev_id', '=', 'property.prop_developer')
                ->orderBy('prop_date_up','desc')
                ->select('property.prop_slug','property.prop_price','property.prop_bed','property.prop_area','property.prop_name','gallery_images.img_path','developer.dev_name')
                ->groupBy('prop_name')
                ->limit(12)
                ->get();
        foreach ($prop as $key => $value) {
            $img = $value->img_path;
            $parths = explode('/', $img);
            $thumb_file = $img;
            if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
            }
            $prop[$key]->img = $thumb_file;
            $prop[$key]->dev = $value->dev_name;
            $prop[$key]->slug = 'property/' . $prop[$key]->prop_slug;
        }
        $data['latest'] = $prop;

        //Featured Promos and New Property
        $pronewids = explode(',', Featured::where('feat_type',1)->pluck('propfeat')->first());

        $pronew = Promonewproject::whereIn('pronew_slug',$pronewids)->where('pronew_status',1)
                    ->leftjoin('property','property.prop_slug','like','promonewproject.pronew_properties')
                    ->leftjoin('gallery_images','gallery_images.img_id','=','property.prop_featured_image')
                    ->leftjoin('location','location.loc_id','=','property.prop_location')
                    ->leftjoin('developer','developer.dev_id','=','promonewproject.pronew_dev')
                    ->leftjoin('gallery_images as dev_img','dev_img.img_id','=','developer.dev_image')
                    ->select('property.prop_slug','property.prop_code','property.prop_price','property.prop_featured_image','developer.dev_name','developer.dev_slug','promonewproject.pronew_type','promonewproject.pronew_name','promonewproject.pronew_blurb','gallery_images.img_path','location.loc_name','dev_img.img_path as dev_img')
                    ->get();
        foreach ($pronew as $key => $value) {
                $data['pronew'][$key]['price'] = $value->prop_price;
                $data['pronew'][$key]['location'] =$value->loc_name;
                $data['pronew'][$key]['slug'] = 'property/' . $value->prop_slug;
                $value->img =  $value->img_path;
                $parths = explode('/', $value->img);
                $thumb_file = $value->img;
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

                $d_parths = explode('/', $value->dev_img);
                $d_thumb_file = $value->dev_img;
                if(file_exists($d_parths[0] . '/tiny/' . $d_parths[1])){
                    $d_thumb_file = $d_parths[0] . '/tiny/' . $d_parths[1];
                }else if(file_exists($d_parths[0] . '/thumbs/' . $d_parths[1])){
                    $d_thumb_file = $d_parths[0] . '/thumbs/' . $d_parths[1];
                    }
                $data['pronew'][$key]['img'] = $thumb_file;
                $data['pronew'][$key]['dev'] = $value->dev_name;
                $data['pronew'][$key]['dev_slug'] = $value->dev_slug;
                $data['pronew'][$key]['dev_img'] = $d_thumb_file;
                $data['pronew'][$key]['type'] = $value->pronew_type;
                $data['pronew'][$key]['name'] = $value->pronew_name;
                $data['pronew'][$key]['blurb'] = $value->pronew_blurb;
        }
        // //featured communities data construction
        $featids = explode(',', Featured::where('feat_type',0)->pluck('propfeat')->first());
        $feat = SpecialProperty::whereIn('sprop_id',$featids)
                ->join('gallery_images','gallery_images.img_id','=','special_property.sprop_bg')
                ->select('gallery_images.img_path','special_property.sprop_name','special_property.sprop_description','special_property.sprop_slug')
                ->get();
        foreach ($feat as $key => $value) {
                $parths = explode('/', $value->img_path);
                if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                    $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                }else{
                    $thumb_file = $value->img_path;
                }
                $data['featured'][$key]['img'] = $thumb_file;
                $data['featured'][$key]['name'] = $value->sprop_name;
                $data['featured'][$key]['blurb'] = substr(preg_replace('/[\n\t\r]+/',' ',(strip_tags($value->sprop_description))),0,250) . '...';
                $data['featured'][$key]['slug'] = 'community/' . $value->sprop_slug;
        }
        return View::make('home',$data)->render();
    }
    public function abus()
    {
        return View::make('abus')->render();
    }
    public function conus()
    {
        return View::make('conus')->render();
    }
    public function sitemap()
    {
        return View::make('sitemap')->render();
    }
    public function terms()
    {
        return View::make('terms')->render();
    }
    // public function propro()
    // {
    //     return View::make('propro')->render();
    // }
    public function testimonials()
    {
        $data['testimonials'] = Testimonial::whereIn('testimony_status',[1])->paginate(12);
        return View::make('testimony',$data)->render();
    }
    public function cookie()
    {
        return View::make('cookie')->render();
    }
    //location index
    // public function listprop(){
    //     return View::make('listprop')->render();
    // }
    //location Page
    public function location(Property $prop, Location $loc, $slug){
        if ($loc->exists($slug)) {
            $data['props'] = $prop->getActiveByLoc($loc->getLocId($slug));
            $data['slug'] = $loc->getLocName($slug);
            foreach ($data['props'] as $key => $value) {
                $data['props'][$key]->prop_loc = Location::where('loc_id',$data['props'][$key]->prop_location)->pluck('loc_name')->first();
                $data['props'][$key]->prop_dev = Developer::where('dev_id',$data['props'][$key]->prop_developer)->pluck('dev_name')->first();
                $img = GalleryImage::where('img_id',$data['props'][$key]->prop_featured_image)->pluck('img_path')->first();
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
                $data['props'][$key]->prop_img = $thumb_file;
            }
            return View::make('properties.filtered_props',$data)->render();
        }else{
            return View::make('errors.404');
        }
    }

    public function type(Property $prop, Developer $dev, $slug){
        if ($slug == 'all') {
            $data['props'] = $prop->getActiveAll();
            foreach ($data['props'] as $key => $value) {
                $data['props'][$key]->prop_loc = Location::where('loc_id',$data['props'][$key]->prop_location)->pluck('loc_name')->first();
                $data['props'][$key]->prop_dev = $dev->where('dev_id',$data['props'][$key]->prop_developer)->pluck('dev_name')->first();
                $img = GalleryImage::where('img_id',$data['props'][$key]->prop_featured_image)->pluck('img_path')->first();
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
                $data['props'][$key]->prop_img = $thumb_file;
            }
            $data['slug'] = $slug;
            return View::make('properties.filtered_props',$data)->render();
        }else if($dev->isActive($slug)){
            $devid = $dev->where('dev_slug',$slug)->first();
            $data['props'] = $prop->getByDeveloper($devid->dev_id);
            foreach ($data['props'] as $key => $value) {
                $data['props'][$key]->prop_loc = Location::where('loc_id',$data['props'][$key]->prop_location)->pluck('loc_name')->first();
                $data['props'][$key]->prop_dev = $devid->dev_name;
                $img = GalleryImage::where('img_id',$data['props'][$key]->prop_featured_image)->pluck('img_path')->first();
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
                $data['props'][$key]->prop_img = $thumb_file;
            }
            $data['slug'] = $devid->dev_name;
            return View::make('properties.filtered_props',$data)->render();
        }else{
            return View::make('errors.404');
        }
        
    }

    public function promos(){
        $data['prop'] = Promonewproject::where('pronew_status',1)
                            ->join('property','property.prop_slug','=','promonewproject.pronew_properties')
                            ->join('gallery_images','gallery_images.img_id','=','property.prop_featured_image')
                            ->join('location','location.loc_id','=','property.prop_location')
                            ->join('developer','developer.dev_id','=','promonewproject.pronew_dev')
                            ->select('property.prop_slug','property.prop_code','property.prop_price','property.prop_featured_image','developer.dev_name','developer.dev_slug','promonewproject.pronew_type','promonewproject.pronew_name','promonewproject.pronew_blurb','gallery_images.img_path','location.loc_name')
                            ->orderBy('pronew_date_up','desc')
                            ->paginate(8);
        foreach ($data['prop'] as $key => $value) {
                $data['pronew'][$key]['price'] = $value->prop_price;
                $data['pronew'][$key]['location'] =$value->loc_name;
                $data['pronew'][$key]['slug'] = 'property/' . $value->prop_slug;
                $value->img =  $value->img_path;
                $parths = explode('/', $value->img);
                $thumb_file = $value->img;
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
                $data['pronew'][$key]['img'] = $thumb_file;
                $data['pronew'][$key]['dev'] = $value->dev_name;
                $data['pronew'][$key]['dev_slug'] = $value->dev_slug;
                $data['pronew'][$key]['type'] = $value->pronew_type;
                $data['pronew'][$key]['name'] = $value->pronew_name;
                $data['pronew'][$key]['blurb'] = $value->pronew_blurb;
        }
        return View::make('properties.promos',$data);
    }
    //tags
    public function tagList(){
        $data['tags'] = Tags::all();
        return View::make('tags.index',$data);
    }
    public function tags($tag){
        $t = str_replace('-', ' ', $tag);
        $props = TagsProp::join('property','property.prop_id','=','tags_prop.prop_id')
                            ->Join('gallery_images','gallery_images.img_id','=','property.prop_featured_image')
                            ->join('tags','tags.tags_id','=','tags_prop.tags_id')
                            ->select('property.*')
                            ->where('tags.tag_name',$t)
                            ->get();

        foreach ($props as $key => $value) {
            $img = $props[$key]->img_path;
                $parths = explode('/', $img);
                // dd($parths);
                if(file_exists($parths[0] . '/thumbs/' . $parths[1])){
                    $thumb_file = $parths[0] . '/thumbs/' . $parths[1];
                }else{
                    $thumb_file = $img;
            }
            $dirs[$key]['name'] = $props[$key]->dev_name;
            $dirs[$key]['img'] = $thumb_file;
            $dirs[$key]['slug'] = 'developer/'.$props[$key]->dev_slug;
            $dirs[$key]['blurb'] = $props[$key]->dev_desc;
        }
        $data['props'] = $props;
        
        $data['blog'] = TagsBlog::join('blog','blog.blog_id','=','tags_blog.blog_id')
                            ->join('tags','tags.tags_id','=','tags_blog.tags_id')
                            ->select('blog.*')
                            ->where('tags.tag_name',$t)
                            ->get();
        $data['tag'] = $t;
        return View::make('tags.tag',$data);

    }
    public function search(Property $prop,Carbon $c, Request $r){
        $currUrl = $r->url();
        $inputs = $r->all();
        $keywords = $inputs['keywords'];
        $prop = $prop->leftjoin('gallery_images','gallery_images.img_id','=','property.prop_featured_image')
                ->leftjoin('developer','developer.dev_id','=','property.prop_developer')
                ->leftjoin('gallery_images as dev_img','dev_img.img_id','=','developer.dev_image')
                ->leftjoin('location','location.loc_id','=','property.prop_location')
                ->select('gallery_images.img_path','developer.dev_name','dev_img.img_path as dev_img','developer.dev_slug','location.loc_name','property.prop_name','property.prop_developer','property.prop_type','property.prop_date_fin','property.prop_date_null','property.prop_code','property.prop_area','property.prop_slug','property.prop_location','property.prop_bed','property.prop_price','property.prop_status');
        if (isset($inputs['keywords'])) {
            $prop = $prop->where(function ($query) use ($inputs,$keywords) {
                    if (strpos($keywords, ',')) {
                        foreach (explode(',',$keywords) as $key => $value) {
                            $query->orWhere('prop_name','like','%'. $value .'%')
                            ->orWhere('loc_name','like','%'. $value .'%')
                            ->orWhere('prop_meta_key','like','%'. $value .'%')
                            ->orWhere('dev_name','like','%'. $value .'%');
                        }
                    }else{
                        $query->where('prop_name','like','%'. $inputs['keywords'] .'%')
                        ->orWhere('loc_name','like','%'. $inputs['keywords'] .'%')
                        ->orWhere('prop_meta_key','like','%'. $inputs['keywords'] .'%')
                        ->orWhere('dev_name','like','%'. $inputs['keywords'] .'%');
                    }
                });
        }else{
            $inputs['keywords'] = null;
        }
            
        if (isset($inputs['dev'])) {
            if($inputs['dev'] != 'any'){
                $prop = $prop->where('prop_developer',$inputs['dev']);
            }
        }else{
            $inputs['dev'] = 'any';
        }
        if (isset($inputs['type'])) {
            if($inputs['type'] != 'any'){
                $prop = $prop->where('prop_type',$inputs['type']);
            }
        }else{
            $inputs['type'] = 'any';
        }

        $date_now = $c->now();
        $date_min = (isset($inputs['handf']) && (strtolower($inputs['handf']) != 'any' && strtolower($inputs['handf']) != 'fin' && strtolower($inputs['handf']) != 'soon')) ? $c->createFromFormat('Y-m-d H:i:s',$inputs['handf']) : null;
        $date_max = (isset($inputs['handt']) && (strtolower($inputs['handt']) != 'any' && strtolower($inputs['handt']) != 'fin' && strtolower($inputs['handt']) != 'soon')) ? $c->createFromFormat('Y-m-d H:i:s',$inputs['handt']) : null;
        if (isset($inputs['handf']) && (strtolower($inputs['handf']) == 'fin' || strtolower($inputs['handf']) == 'soon')) {
            if($inputs['handf'] == 'fin'){
                $prop = $prop->where('prop_date_fin','<',$date_now);
            }
            if($inputs['handf'] == 'soon'){
                $prop = $prop->where('prop_date_null',1);
            }
        }else if($date_min) {
            $prop = $prop->where('prop_date_fin','>',$date_min);
        }else{
            $inputs['handf'] = 'any';
        }


        if (isset($inputs['handt']) && (strtolower($inputs['handt']) == 'fin' || strtolower($inputs['handt']) == 'soon')) {
            if($inputs['handt'] == 'fin'){
                if(!$inputs['handf'] == 'fin' && isset($inputs['handf'])){
                    $prop = $prop->where('prop_date_fin','<',$date_now);
                }
            }
            if($inputs['handt'] == 'soon'){
                $prop = $prop->where('prop_date_null',1);
            }
        }else if($date_max) {
            $prop = $prop->where('prop_date_fin','<',$date_max);
        }else{
            $inputs['handt'] = 'any';
        }


        // if(isset($inputs['hand'])){
        //     foreach ($inputs['hand'] as $key => $value) {
        //         if (is_numeric($value)) {
        //             $date_min = $c->create($value,1,1,0,0,0);
        //             $date_max = $c->create($value,12,30,0,0,0);
        //             if (sizeof($inputs['hand']) > 1) {
        //                 $prop = $prop->orWhereBetween('prop_date_fin',[$date_min,$date_max]);
        //             }else{
        //                 $prop = $prop->whereBetween('prop_date_fin',[$date_min,$date_max]);
        //             }
        //         }else if ($value == 'fin') {
        //             $date_max = $c->today();
        //             if (sizeof($inputs['hand']) > 1) {
        //                 $prop = $prop->orWhere('prop_date_fin','<',$date_max);
        //             }else{
        //                 $prop = $prop->where('prop_date_fin','<',$date_max);
        //             }
        //         }
        //     }
        //     if (in_array('cs', $inputs['hand'])) {
        //         if (sizeof($inputs['hand']) > 1) {
        //             $prop = $prop->orWhere('prop_date_null',1);
        //         }else{
        //             $prop = $prop->where('prop_date_null',1);
        //         }
        //     }else{
        //         $prop->where(function ($query) {
        //                 $query->whereNull('prop_date_null')
        //                 ->orWhere('prop_date_null',0);
        //         });
        //     }
        // }

        if (isset($inputs['loc'])) {
            if($inputs['loc'] != 'any'){
                $prop = $prop->where('prop_location',$inputs['loc']);
            }
        }else{
            $inputs['loc'] = 'any';
        }

        $an = $inputs['area_min'];
        $ax = $inputs['area_max'];

        if (isset($an) && $an < 0) {
            $an = 1;
        }

        if (isset($ax) && $an < 0) {
            $ax = 1;
        }

        if (isset($an) && isset($ax)) {
            if ($an > $ax) {
                $ax = $an + 100;
            }
            $prop = $prop->whereBetween('prop_area',[$an,$ax]);
        }else if (isset($an) && !isset($ax)) {
            $prop = $prop->where('prop_area','>=',$an);
        }else if (isset($ax) && !isset($an)) {
            $prop = $prop->where('prop_area','<=',$ax);
        }
        $inputs['area_min'] = $an;
        $inputs['area_max'] = $ax;


        if (isset($inputs['beds'])) {
            if(strtolower($inputs['beds']) != 'any'){
                $prop = $prop->where('prop_bed','>=',$inputs['beds']);
            }
        }else{
            $inputs['beds'] = 'any';
        }

        if (isset($inputs['bedm'])) {
            if(strtolower($inputs['bedm']) != 'any'){
                $prop = $prop->where('prop_bed','<=',$inputs['bedm']);
            }
        }else{
            $inputs['bedm'] = '10';
        }

        if (isset($inputs['price_min'])) {
            if($inputs['price_min'] != 'any'){
                if($inputs['price_min'] == 'pa'){
                    $prop = $prop->where('prop_price','>=',0);
                }else{
                    if(strpos($inputs['price_min'],'k')){
                        $p = (str_replace('k', '', $inputs['price_min'])) * 1000;
                    }else if (strpos($inputs['price_min'],'m')) {
                        $p = (str_replace('m', '', $inputs['price_min'])) * 1000000;
                    }
                    $prop = $prop->where('prop_price','>=',$p);
                }
            }else{
                $inputs['price_min'] = 'any';
            }
        }else{
            $inputs['price_min'] = 'any';
        }

        if (isset($inputs['price_max'])) {
            if($inputs['price_max'] != 'any' && $inputs['price_max'] != 'pa'){
                if(strpos($inputs['price_max'],'k')){
                    $p = (str_replace('k', '', $inputs['price_max'])) * 1000;
                }else if (strpos($inputs['price_max'],'m')) {
                    $p = (str_replace('m', '', $inputs['price_max'])) * 1000000;
                }
                $prop = $prop->where('prop_price','<=',$p);
            }
        }else{
            $inputs['price_max'] = null;
        }

        if (isset($inputs['ord'])) {
            switch ($inputs['ord']) {
                case 'lp':
                    $prop = $prop->orderBy('prop_price','ASC');
                    break;
                case 'hp':
                    $prop = $prop->orderBy('prop_price','DESC');
                    break;
                case 'ha':
                    $prop = $prop->orderBy('prop_area','DESC');
                    break;
                case 'la':
                    $prop = $prop->orderBy('prop_area','ASC');
                    break;
                case 'hb':
                    $prop = $prop->orderBy('prop_bed','DESC');
                    break;
                case 'lb':
                    $prop = $prop->orderBy('prop_bed','ASC');
                    break;
                
                default:
                    $prop = $prop->orderBy('prop_date_up','DESC');
                    $inputs['ord'] = 'any';
                    break;
            }
        }else{
            $prop = $prop->orderBy('prop_date_up','DESC');
            $inputs['ord'] = 'any';
        }

        $data['data'] = $prop->whereIn('prop_status',[1])->paginate(10);
        foreach ($data['data'] as $key => $value) {
                    $img = $data['data'][$key]->img_path;
                    $thumb_file = $img;
                    $parths = explode('/', $img);
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
                    $d_img = $data['data'][$key]->dev_img;
                    $d_parths = explode('/', $d_img);
                    $d_thumb_file = $d_img;
                    if(file_exists($d_parths[0] . '/tiny/' . $d_parths[1])){
                            $d_thumb_file = $d_parths[0] . '/tiny/' . $d_parths[1];
                    }
                    $data['data'][$key]->prop_img = $thumb_file;
                    $data['data'][$key]->dev_img = $d_thumb_file;
                    $data['data'][$key]->prop_loc = $data['data'][$key]->loc_name;
                    $data['data'][$key]->prop_dev = $data['data'][$key]->dev_name;
                    $date = $c->parse($data['data'][$key]->prop_date_fin);
                    $data['data'][$key]->finished = ($c->now()->diffInDays($date,false) <= 0) ? 1 : 0 ;
                    $data['data'][$key]->mated_date = 'Q' . $date->quarter . ' ' . $date->year;
        }
        $data['li'] = $inputs;
        return View::make('search.result',$data)->render();
    }
    //blog
    public function blog($page = 0){
        $limit = 5;
        $maxPages = ceil(Blog::where('blog_status',1)->count() / $limit);
        $skip = ($page == 0) ? 0 : $limit * ($page-1);
        $data['prev_page'] = ($page == 0)? $page : $page - 1;
        $data['next_page'] = ($page < $maxPages) ? ($page == 0 ? 1 : $page)+1 : 0;
        $data['data'] = Blog::leftjoin('gallery_images','gallery_images.img_id','=','blog.blog_img')
                                ->leftjoin('author','author.author_id','=','blog.blog_author')
                                ->orderBy('blog_date_up','desc')
                                ->where('blog_status',1)
                                ->select('blog.*','author.*','gallery_images.img_path')
                                ->skip($skip)->limit($limit)->get();
        foreach ($data['data'] as $key => $value) {
            $img = $value->img_path;
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
            $data['data'][$key]->blog_img = $thumb_file;
        }
        return View::make('blog.blog',$data)->render();
    }

    public function author(){
        $data['data'] = Author::paginate(9);
        return View::make('blog.author',$data)->render();
    }

    public function locationSearch(){
        return View::make('search.loc_search');
    }
    
    public function propximity(Request $r){
        $inputs = $r->all();
        if ($r->get('location')) {
            $coords = explode(',',$r->get('location'));
        }
        $latitude = isset($coords[0]) ? $coords[0] : 25.200952;
        $longitude = isset($coords[1]) ? $coords[1] : 55.28082;
        $distance = $r->get('proximity') ?: 5;
        $unit = $r->get('unit') ?: 'k';

        switch ($unit){
            /*** miles ***/
            case 'Miles':
            $unit = 3963;
            break;
            /*** nautical miles ***/
            default:
            /*** kilometers ***/
            $unit = 6371;
        }

        try
        {
            $sql = Property::with('location','featured')->selectRaw("*, ( {$unit} * ACOS( COS( RADIANS({$latitude}) ) * COS( RADIANS( prop_lat ) ) * COS( RADIANS( prop_long ) - RADIANS({$longitude}) ) + SIN( RADIANS({$latitude}) ) * SIN( RADIANS( prop_lat ) ) ) ) AS distance")
                ->havingRaw('distance < ?',[$distance])->get();
            /*** an instance of PDO singleton ***/
            /*** execute the query ***/
            /*** return the distance ***/
            foreach ($sql as $k => $v) {
                $data[$k]['Property_Title'] = $v->prop_name;
                $data[$k]['Price'] = $v->prop_price ?: 'Price on Application' ;
                $data[$k]['Feathumb'] = $v->featured->img_path;
                $data[$k]['Location'] = $v->location->loc_name;
                // $data['Sublocation'] = $v->prop_slug;
                $data[$k]['Latitude'] = $v->prop_lat;
                $data[$k]['Longitude'] = $v->prop_long;
                $data[$k]['Unit_Type'] = $v->prop_type;
                $data[$k]['slug'] = $v->prop_slug;
            }
            if (isset($data)) {
                return response()->json(['status'=>true,'datum'=>$data],200);
            }else{
                return response()->json(['status'=>false,'message'=>'No properties inside proximity'],200);
            }
            // return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }
        catch( \Exception $e )
        {
            return response()->json(['status'=>false,'message'=>'Something went wong' . $e],200);
        }
    }    
}