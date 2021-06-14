<?php

namespace App\Http\Controllers;

use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
            $adminCount = Admin::where(['name'=>$data['username'],'password'=>$data['password']])->count();
            // echo "<pre>"; print_r($adminCount);die;
            if($adminCount > 0){
                Session::put('adminSession',$data['username']);
                $adminDetails = Admin::where(['status'=>1])->first();
                return redirect('admin/dashboard')->with(compact('adminDetails'));
            }else{
                return redirect('/admin')->with('flash_message_error','Invalid username of password!!');
            }
        }
        return view('admin.admin_login');
    }
    public function logout(){
        Session::forget('adminSession');
        Session::forget('session_id');
        return redirect('/admin')->with('flash_message_success','Logout successfully');
    }
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function addAdmin(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            $adminCount = Admin::where('email',$data['admin_email'])->count();
            if($adminCount > 0){
                return redirect()->back()->with('flash_message_error','Email is already exist');
            }else{
               //adding user
               $admin = new Admin();
               $admin->name = $data['admin_name'];
               $admin->email = $data['admin_email'];
               $admin->password = md5($data['admin_password']);
               $admin->save();
                return redirect()->back()->with('flash_message_success','New Admin is Added!');
               }
            }
            $adminDetails = Admin::where(['status'=>1])->first();
           return view('admin.add_admin')->with(compact('adminDetails'));
    }
    public function viewAdmins(){
        $adminDetail = Admin::get();
        $adminDetails = Admin::where(['status'=>1])->first();
        return view('admin.view_admin')->with(compact('adminDetail','adminDetails'));
    }
}
