<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use View;
use Excel;
use PDF;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerInquiry;
use App\Models\File;
use App\Models\Developer;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Testimonial;
use App\Models\Location;
use App\Models\Property;
use App\Models\Featured;
use App\Models\Blog;
use App\Models\Author;
use App\Models\SpecialProperty;
use App\Models\Promonewproject;
use App\Models\Newsletter;
use App\Models\PropertyListing;
use App\Models\Tag;
use App\Models\TagsBlog;
use App\Models\TagsProp;


class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Newsletter $news)
    {
        if ( Auth::user()->level > 3 ) {
            return abort('404');
        }
        $data = $news->all();
        return view('admin.admin',compact('data'));
    }

    function subs_export(Newsletter $res){
        $data = $res->get(['news_email as Subscription Email','news_date_up as Date Subscribed']);
        return Excel::create('Subscriptions-' . \Carbon\Carbon::now(), function($excel) use ($data) {
        $excel->sheet('mySheet', function($sheet) use ($data)
        {
            $sheet->fromArray($data);
        });
         })->download("csv");
    }

    function files()
    {
        $data['files'] = File::get();
        return view('admin.files',$data)->render();
    }

    function testimony(){
        $data['testimonials'] = Testimonial::orderBy('testimony_status','desc')->whereNotIn('testimony_status',[4])->orderBy('testimony_date_up','asc')->get();
        foreach ($data['testimonials'] as $key => $value) {
            if($data['testimonials'][$key]->testimony_status == 1){
                $data['testimonials'][$key]->testimony_stat = 'Approved';
            }elseif($data['testimonials'][$key]->testimony_status == 2){
                $data['testimonials'][$key]->testimony_stat = 'Rejected';
            }elseif($data['testimonials'][$key]->testimony_status == 3){
                $data['testimonials'][$key]->testimony_stat = 'Pending';
            }else{
                $data['testimonials'][$key]->testimony_stat = 'Deleted';
            }
        }
        return view('admin.testimony',$data)->render();
    }
        function blog(){
        $data['blogs'] = Blog::orderBy('blog_date_up','desc')->get();
        foreach ($data['blogs'] as $key => $value) {
            //status construction
            if($data['blogs'][$key]->blog_status == 1){
                $data['blogs'][$key]->blog_stat = 'Published';
            }elseif($data['blogs'][$key]->blog_status == 2){
                $data['blogs'][$key]->blog_stat = 'Draft';
            }else{
                $data['blogs'][$key]->blog_stat = 'Deleted';
            }
            //author name construction
            $author_name = Author::where('author_id',$data['blogs'][$key]->blog_author)->first(['author_fname as fname','author_lname as lname']);
            $author_name['complete'] = $author_name->fname . ' ' . ($author_name->lname ? $author_name->lname : '');
            $data['blogs'][$key]->blog_author = $author_name['complete'];
        }
        return view('admin.blog',$data)->render();
    }

    function author(){
        $data['authors'] = Author::get();
        return view('admin.author',$data)->render();
    }

    function sprop(){
        $data['sprops'] = SpecialProperty::orderBy('sprop_date_up','desc')->orderBy('sprop_status','asc')->whereNotIn('sprop_status',[4])->get();
        foreach ($data['sprops'] as $key => $value) {
            $data['sprops'][$key]->sprop_developer = Developer::where('dev_id',$data['sprops'][$key]->sprop_dev)->pluck('dev_name')->first();
            if($data['sprops'][$key]->sprop_status == 1){
                $data['sprops'][$key]->sprop_stat = 'Published';
            }elseif($data['sprops'][$key]->sprop_status == 2){
                $data['sprops'][$key]->sprop_stat = 'Draft';
            }elseif($data['sprops'][$key]->sprop_status == 3){
                $data['sprops'][$key]->sprop_stat = 'Pending';
            }else{
                $data['sprops'][$key]->sprop_stat = 'Deleted';
            }
        }
        return view('admin.sprop',$data)->render();
    }
    function pronew(){
        $data['pronews'] = Promonewproject::orderBy('pronew_date_up','desc')->orderBy('pronew_status','asc')->whereNotIn('pronew_status',[4])->get();
        foreach ($data['pronews'] as $key => $value) {
            $data['pronews'][$key]->type = $data['pronews'][$key]->pronew_type == 1 ? 'New Project' : 'Promo' ;
            $data['pronews'][$key]->pronew_developer = Developer::where('dev_id',$data['pronews'][$key]->pronew_dev)->pluck('dev_name')->first();
            if($data['pronews'][$key]->pronew_status == 1){
                $data['pronews'][$key]->pronew_stat = 'Published';
            }elseif($data['pronews'][$key]->pronew_status == 2){
                $data['pronews'][$key]->pronew_stat = 'Draft';
            }elseif($data['pronews'][$key]->pronew_status == 3){
                $data['pronews'][$key]->pronew_stat = 'Finished';
            }else{
                $data['pronews'][$key]->pronew_stat = 'Deleted';
            }
        }
        return view('admin.pronew',$data)->render();
    }
    function prop()
    {
        $data['props'] = Property::orderBy('prop_date_up','desc')->orderBy('prop_status','asc')->whereNotIn('prop_status',[4])->get();
        foreach ($data['props'] as $key => $value) {
            $data['props'][$key]->prop_loc = Location::where('loc_id',$data['props'][$key]->prop_location)->pluck('loc_name')->first();
            $data['props'][$key]->prop_dev = Developer::where('dev_id',$data['props'][$key]->prop_developer)->pluck('dev_name')->first();

            if($data['props'][$key]->prop_status == 1){
                $data['props'][$key]->prop_stat = 'Published';
            }elseif($data['props'][$key]->prop_status == 2){
                $data['props'][$key]->prop_stat = 'Draft';
            }elseif($data['props'][$key]->prop_status == 3){
                $data['props'][$key]->prop_stat = 'Pending';
            }else{
                $data['props'][$key]->prop_stat = 'Deleted';
            }


        }
        return view('admin.prop',$data);
    }

    function propExporter()
    {
        $title = "Property-Report-";
        $data['props'] = Property::orderBy('prop_name','asc')->orderBy('prop_bed','asc')->whereNotIn('prop_status',[4])->get(['prop_code as Property Code','prop_name as Property Name','prop_developer as Developer','prop_location as Location','prop_status as Status','prop_bed as Bed', 'prop_price as Price','prop_area as Area']);
        foreach ($data['props'] as $key => $value) {
            $data['props'][$key]->Location = Location::where('loc_id',$data['props'][$key]->Location)->pluck('loc_name')->first();
            $data['props'][$key]->Developer = Developer::where('dev_id',$data['props'][$key]->Developer)->pluck('dev_name')->first();
            $data['props'][$key]->Price_per_sqft = !is_null($data['props'][$key]->Area) ? round($data['props'][$key]->Price / $data['props'][$key]->Area,2) . ' AED/sqft' : 'No Area Provided';
            $data['props'][$key]->Area = !is_null($data['props'][$key]->Area) ? $data['props'][$key]->Area . ' sqft' : 'No Area Provided' ;
            if($data['props'][$key]->Bed <= 0){
                $data['props'][$key]->Bed = 'Studio';
            }
            if($data['props'][$key]->Status == 1){
                $data['props'][$key]->Status = 'Published';
            }elseif($data['props'][$key]->Status == 2){
                $data['props'][$key]->Status = 'Draft';
            }elseif($data['props'][$key]->Status == 3){
                $data['props'][$key]->Status = 'Pending';
            }else{
                $data['props'][$key]->Status = 'Deleted';
            }


        }
        $this->exportCSV($data['props'],$title);
    }

    function loc()
    {
        $data['location'] = Location::get();
        foreach ($data['location'] as $key => $value) {
            $id = explode(',', $data['location'][$key]->loc_img);
            $img_path = GalleryImage::where('img_id',$id[0])->first();
            $data['location'][$key]->loc_img = $img_path['img_path'];
        }
        return view('admin.loc',$data);
    }
    function dev()
    {
        $data['developer'] = Developer::get();
        foreach ($data['developer'] as $key => $value) {
            $id = explode(',', $data['developer'][$key]->dev_image);
            $img_path = GalleryImage::where('img_id',$id[0])->first();
            $data['developer'][$key]->dev_img = $img_path['img_path'];
        }
        return view('admin.dev',$data);
    }

    function gal()
    {
        $data['gallery'] = Gallery::all();
        return view('admin.gal',$data);
    }

    function imgup(GalleryImage $gi)
    {
        $data['images'] = $gi->orderBy('img_uploaded','desc')->get();
        return view('admin.imgup',$data)->render();
    }

     function inquiries()
    {
        $data['inquires'] = CustomerInquiry::orderBy('date_inquired','desc')->get();
        return view('admin.inquiries',$data);
    }

    function sort(){
        $data['data'] = 'asdasdasdasd';
        return view('admin.admin',$data);
    }
    function export(){
        $data = [];
        $proj_name = CustomerInquiry::get()->groupBy('project_name')->toArray();
        foreach ($proj_name as $key => $value) {
            $data['proj'][$key] = $key;
        }

        return View::make('admin.exporter',$data)->render();
    }
    function exporter(Request $r,CustomerInquiry $ci){
        $title = "Inquiries-";
        $inputs = $r->all();
        if ($inputs['num'] != 'all') {
            $ci = $ci->limit($inputs['num']);
        }

        if ($inputs['proj_name'] != 'all') {
            $ci = $ci->where('project_name',$inputs['proj_name']);
        }

        if (isset($inputs['date_from'])) {
            $dafro = date_format(date_create($inputs['date_from']),"Y/m/d H:i:s");;
            $ci = $ci->where('date_inquired', '>=', $dafro);
        }

        if (isset($inputs['date_to'])) {
            $dato = date_format(date_create($inputs['date_to']),"Y/m/d H:i:s");;
            $ci = $ci->where('date_inquired', '<=', $dato);
        }
        $res = $ci->get();

        if($inputs['rep_type'] == 'csv'){
            $this->exportCSV($res,$title);
        }
        if($inputs['rep_type'] == 'xls'){
            $this->exportXLS($res,$title);
        }
        if($inputs['rep_type'] == 'pdf'){
            $data['reps'] = $res;
            $data['proj_name'] =  isset($inputs['proj_name']) ? $inputs['proj_name'] : '' ;
            $data['date_from'] =  isset($inputs['date_from']) ? $inputs['date_from'] : '' ;
            $data['date_to'] =  isset($inputs['date_to']) ? $inputs['date_to'] : '' ;
          return  $this->exportPDF($data,$title);
        }
    }

    public function exportPDF($res,$title)
    {    
        //GET OFFER DATA
        $data = $res;
        //GET CLIENT DATA
        $pdf = PDF::loadView('admin.reps', $data)->setPaper('a4', 'landscape');

        return $pdf->download($title . \Carbon\Carbon::now() . '.pdf');


    }

    public function exportCSV($res,$title)
    {
       $data = $res;
       return Excel::create($title . \Carbon\Carbon::now(), function($excel) use ($data) {
        $excel->sheet('mySheet', function($sheet) use ($data)
        {
            $sheet->fromArray($data);
        });
       })->download("csv");
    }

    public function exportXLS($res,$title)
    {
       $data = $res;
       return Excel::create($title . \Carbon\Carbon::now(), function($excel) use ($data) {
        $excel->sheet('mySheet', function($sheet) use ($data)
        {
            $sheet->fromArray($data);
        });
       })->download("xls");
    }


    function featsave(Request $r){
        $inputs = $r->except('_token');
        $idarr = explode(',', $inputs['propfeat']);
        if (sizeof($idarr) < 3) {
            $r->flash();
            Session::flash('message','Please Select 3 or more properties to feature.');
        }else{
            $r->flash();
            $feats = Featured::where('feat_type',0)->first();
            if($feats){
                if($feats->where('feat_type',0)->update($inputs)){
                    Session::flash('message','Featured Properties Saved Successfuly');
                }else{
                    Session::flash('message','Oops Something went wrong. Please contact your IT personel');
                }
            }else{
                if(Featured::insert($inputs)){
                    Session::flash('message','Featured Properties Saved Successfuly');
                }else{
                    Session::flash('message','Oops Something went wrong. Please contact your IT personel');
                }
            }
        }
        return redirect('admin/feat');
    }
    function mig(Property $prop,SpecialProperty $sprop){
        $coms = $sprop->where('sprop_status',1)->select('sprop_properties','sprop_id','sprop_status')->get();
        foreach ($coms as $sk => $sv) {
            $ids = explode(',', rtrim($sv->sprop_properties,','));
            $props = $prop->whereIn('prop_code',$ids)->select('prop_id','prop_code')->get();
            foreach ($props as $key => $value) {
                $prop->where('prop_id',$value->prop_id)->update(['prop_community'=>$sv->sprop_id]);
                echo 'updated - ' . $value->prop_code . ' asigned to community - ' . $sv->sprop_id . '<br />';
            }
        }
    }
    function feat(){
        $sprop = SpecialProperty::whereIn('sprop_status',[1])->get();
        // $prop = Property::whereIn('prop_status',[1])->get();
        $data['feat'] = Featured::where('feat_type',0)->first();
        // if ($sprop->count() > 0) {
            for ($i=0; $i < sizeof($sprop); $i++) { 
                $data['prop'][$i]['id'] = $sprop[$i]->sprop_id;
                $data['prop'][$i]['name'] = $sprop[$i]->sprop_name;
            }

            // $count = sizeof($data['prop']);
        // }else{
            // $count = 0;
        // }
        
        
        // for ($i=0,$x=$count; $i < sizeof($prop); $i++,$x++) {
        //     $data['prop'][$x]['id'] = $prop[$i]->prop_code;
        //     $data['prop'][$x]['name'] = $prop[$i]->prop_name;
        // }
        return view('admin.feat',$data);
    }

    function grabTags($t = null){
        $tags = Tag::select('tag_name');
        if (!is_null($t)) {
            $tags = $tags->where('tag_name','like','%'. $t .'%');
        }
        return json_encode($tags->get());
    }

    public function displayTags(){
        $taggers = [];
        $c = 0;
        $tags = Property::select('prop_meta_key','prop_id')->get();
        foreach ($tags as $key => $value) {
            $c++;
            if ($value->prop_meta_key) {
                foreach (explode(',', $value->prop_meta_key) as $k => $val) {
                    $teghi = Tag::firstOrCreate(['tag_name'=>$val]);
                    $tagpr = TagsProp::updateOrCreate(['tags_id'=>$teghi->tags_id,'prop_id'=>$value->prop_id]);
                    $taggers[$c]['ehh'] = $tagpr;
                }
            }
        }
        $tagsb = Blog::select('blog_meta_key','blog_id')->get();
        foreach ($tagsb as $key => $value) {
            $c++;
            if ($value->blog_meta_key) {
                foreach (explode(',', $value->blog_meta_key) as $k => $val) {
                    $teghi = Tag::firstOrCreate(['tag_name'=>$val]);
                    $tagpr = TagsBlog::updateOrCreate(['tags_id'=>$teghi->tags_id,'blog_id'=>$value->blog_id]);
                    $taggers[$c]['ehh'] = $tagpr;
                }
            }
        }
        // $taggers = array_unique($taggers);

        dd($taggers);
    }


}
