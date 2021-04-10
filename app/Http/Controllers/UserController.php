<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hash;
use Validator;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function account(){
        $data['phone']= Auth::user()->mobile;
        $data['user_country']= Auth::user()->country;
        return view('user.account',$data)->render();
    }
    
    public function referals(){
        return view('user.referal')->render();
    }
    
    public function savedProp(){
        return view('user.saveprop')->render();
    }

    public function changePass(Request $r){
        if (!(Hash::check($r->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("passError","Your current password does not match with the password you provided. Please try again.");
        }
 
        if(strcmp($r->get('current-password'), $r->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("passError","New Password cannot be same as your current password. Please choose a different password.");
        }
 
        $validatedData = $r->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($r->get('new-password'));
        $user->save();
 
        return redirect()->back()->with("passSuccess","Password changed successfully !");
    }

    public function changePhone(Request $r){
 
        if(strcmp($r->get('mobile'), Auth::user()->mobile) == 0){
            return redirect()->back()->with("phoneError","New Phone Number cannot be same as your current Phone Number. Please choose a different Phone Number.");
        }
 
        $validatedData = $r->validate([
            'country'  => 'required_with:phone',
            'mobile' => 'required|phone:country',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->mobile = $r->get('mobile');
        $user->country = $r->get('country');
        $user->save();
 
        return redirect()->back()->with("phoneSuccess","Phone Number changed successfully !");

    }
}
