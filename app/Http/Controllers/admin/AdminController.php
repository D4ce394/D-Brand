<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function updateAdminPassword(){
        // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request){
        $data = $request->all();
        echo "<pre>"; print_r($data); die;
    }


    public function login(Request $request){
        // echo $password = Hash::make('12345678'); die;
        
        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
            // echo "<prez>"; print_r($data); die;

            $rules = [ 
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                // add Custom Messages Here
                'email.required' => 'Email Address is required!',
                'email.email' => 'Valid Email Address is required!',
                'password.required' => 'Password is required!',
            ];

            $this->validate($request,$rules,$customMessages);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password'], 'status'=>1])){
            // if(Auth::guard('admin')){
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'Invalid Email or Password');
            }
        }
        return view('admin.login');
    }

    Public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}