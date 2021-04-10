<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyListing;
use App\Models\CustomerInquiry;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Mail\inquirySender;
use App\Models\Newsletter;
use Validator;
use App\User;
use Mail;
use View;

class WebsiteUserController extends Controller
{
    use AuthenticatesUsers;

    public function saveInquiry(Request $r){
        $inputs = $r->except('_token');
        $rules = [
            'name' => 'required|max:50',
            'country'  => 'required_with:phone',
            'phone' => 'required|phone:country',
            'email' => 'required|email|unique:customer_inquiries,email,null,id,project_name,'. $inputs['project_name'],
            'message' =>'max:255'
        ];
        $message = [
            'required' => 'Please Fillup the :attribute field',
            'phone' => 'Please Enter Valid Phone Number',
            'email.unique' => '<b> :input </b> has already been used.',
            'email.email' => 'Please enter a valid :attribute',
            'max' => 'You have exceeded the maximum characters allowed(:max)',
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }else{
            $costumerInq = CustomerInquiry::create($inputs);
            if ($costumerInq) {
                Mail::to('andrew@capriuae.com')->send(new inquirySender($costumerInq));
                // Mail::to('varun.dubairealestate@gmail.com')->cc(['frank.vincent.valenzuela@gmail.com','frank@capriuae.com','varun@capriuae.com'])->send(new inquirySender($costumerInq));
                return json_encode(['success'=>true]);

            }else{
                return json_encode(['success'=>false]);
            }            
        }
    }
    public function testify(Request $r){
        $inputs = $r->except(['_token']);
        $rules = [
            'testimony_name'=>'max:50',
            'testimony_email'=>'required|email',
            'testimony_content'=>'required|max:1000'
        ];
        $message = [
            'testimony_name.max' => 'You have exceeded the maximum characters(50)',
            'testimony_email.required' => 'Please Fill this up. it is required',
            'testimony_email.email' => 'Please enter a valid Email',
            'testimony_content.required' => 'Please Fill this up. it is required',
            'testimony_content.max' => 'You have exceeded the maximum characters(1000)',
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }else{
            if (Testimonial::insert($inputs)) {
                return json_encode(['success'=>true]);
            }else{
                return json_encode(['success'=>false]);
            }            
        }
    }
    public function register(Request $r){
        $inputs = $r->all();
        $rules = [
            'name' => 'required|max:50',
            'country'  => 'required_with:phone',
            'phone' => 'required|phone:country',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:6|confirmed',
        ];
        $message = [
            'required' => 'Please Fillup the :attribute field',
            'phone' => 'Please Enter Valid Phone Number',
            'email.unique' => '<b> :input </b> has already been used.',
            'email.email' => 'Please enter a valid :attribute',
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }else{
            $registered = User::create([
                'name' => $inputs['name'],
                'email' => $inputs['email'],
                'country' => $inputs['country'],
                'mobile' => $inputs['phone'],
                'password' => bcrypt($inputs['password']),
                'reference' => str_random(100),
                'level' => 5,
            ]);
            if($registered){
                Auth::loginUsingId($registered->id);
                return json_encode(['success'=>true,$registered]);
            }else{
                return json_encode(['success'=>false]);
            }
        }

    }
    public function login(Request $request){

        $inputs = $request->all();
         $rules = [
            'email'=>'required|email',
            'password'=>'required|string',
        ];
        $message = [
            'required' => 'Please Fillup the :attribute field',
            'email.email' => 'Please enter a valid :attribute',
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }else{

            if ($this->hasTooManyLoginAttempts($request)) {
                return json_encode(['success'=>false, 'message'=>$this->sendLockoutResponse($request)]);
            }

            if ($this->attemptLogin($request)) {
                return json_encode(['success'=>true, 'message'=>'Sign in Successful']);
            }

            $this->incrementLoginAttempts($request);
            return json_encode(['success'=>false, 'message' =>'Invalid Email and Password']);
        }
    }

    public function newsletter(Request $r){
        $inputs = $r->all();
        $rules = [
            'news_email'=>'required|email|unique:newsletter'
        ];
        $message = [
            'news_email.required' => 'Please Fill up this textbox',
            'news_email.unique' => 'This email is already on our Subscription List.',
            'news_email.email' => 'Please Input Valid Email'
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }else{
            if (Newsletter::insert($inputs)) {
                return json_encode(['success'=>true]);
            }else{
                return json_encode(['success'=>false]);
            }            
        }
    }
    public function saveProp(Request $r){
        $inputs = $r->except(['_token']);
        $rules = [
            'list_fname'=>'required|max:50',
            'list_lname'=>'required|max:50',
            'list_phone'=>'required|numeric',
            'list_email'=>'required|email',
            'list_location'=>'required',
            'list_sub_location'=>'required',
            'list_prop_type'=>'required',
            'list_contract_type'=>'required',
            'list_bed'=>'required|max:2',
            'list_bath'=>'required|max:2',
            'list_area'=>'required|max:7',
            'list_plot'=>'required|max:7',
            'list_price'=>'required|max:15',
            'list_notes'=>'required'
        ];
        $message = [
            'list_fname.required' => 'Please Fill this up. it is required',
            'list_fname.max' => 'You have exceeded the maximum characters',
            'list_lname.required' => 'Please Fill this up. it is required',
            'list_lname.max' => 'You have exceeded the maximum characters',
            'list_phone.required' => 'Please Fill this up. it is required',
            'list_phone.numeric' => 'Please enter a valid Number',
            'list_email.required' => 'Please Fill this up. it is required',
            'list_email.email' => 'Please enter a valid Email',
            'list_location.required' => 'Please Fill this up. it is required',
            'list_sub_location.required' => 'Please Fill this up. it is required',
            'list_prop_type.required' => 'Please Fill this up. it is required',
            'list_contract_type.required' => 'Please Fill this up. it is required',
            'list_bed.required' => 'Please Fill this up. it is required',
            'list_bed.max' => 'You Have Exceeded the maximum characters',
            'list_bath.required' => 'Please Fill this up. it is required',
            'list_bath.max' => 'You Have Exceeded the maximum characters',
            'list_area.required' => 'Please Fill this up. it is required',
            'list_plot.required' => 'Please Fill this up. it is required',
            'list_area.max' => 'You Have Exceeded the maximum characters',
            'list_plot.max' => 'You Have Exceeded the maximum characters',
            'list_price.required' => 'Please Fill this up. it is required',
            'list_price.max' => 'You Have Exceeded the maximum characters',
            'list_notes.required' => 'Please Fill this up. it is required'
        ];
        $validator = Validator::make($inputs,$rules,$message);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }else{
            if (PropertyListing::insert($inputs)) {
                return json_encode(['success'=>true]);
            }else{
                return json_encode(['success'=>false]);
            }            
        }
    }
    public function sitemapSubmit(){
        // $content = View::make('xml.index', $data)->render();

        // File::put(storage_path().'/file.xml', $content);

        // return Response::make($content, 200)->header('Content-Type', 'application/xml');
        
        $data[] = file_get_contents('http://google.com/ping?sitemap=http%3A%2F%2Fwww.offplandeal.com%2Fsitemap.xml');
        $data[] = file_get_contents('http://www.bing.com/ping?sitemap=http%3A%2F%2Fwww.offplandeal.com%2Fsitemap.xml');
        echo "<pre>";
        print_r($data);
    }
}
