<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
   /*  public function loadRegister(){
        if(Auth::user() && Auth::user()->is_admin==1){
            return redirect('/admin/dashboard');
        }else if(Auth::user() && Auth::user()->is_admin==0){
            return redirect('/dashboard');
        }
        return view('register');
    } */

    /* public function userRegister(Request $request){
        //dd('welcome');
        $request->validate([
            'name'=>'string|required|min:2',
            'email'=>'email|required|unique:users',
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password|min:6'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Your Registration has been successfull!');

    } */

    public function loadAdminLogin(){
        if(Auth::user() && Auth::user()->is_admin==1){
            return redirect('/admin/dashboard');
        }else if(Auth::user() && Auth::user()->is_admin==0){
            return back()->with('error', 'Access Denied!');
        }
        return view('login');
    }

    public function adminLogin(Request $request){
        $request->validate([
            'email'=>'email|required',
            'password'=>'required|min:6'
        ]);

        $userCred = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if($user->is_admin == 0 && $user->status == 0){
            return back()->with('error', 'Your Account is diabled!');
        }
        if($user->is_admin == 0){
            return back()->with('error', 'Access Denied!');
        }
        if(Auth::attempt( $userCred )){
                return redirect('/admin/dashboard');

        }
         else{
            return back()->with('error', 'Username & Password is incorrect!');
        }
    }

    public function loadDashboard(){
        return view('user.dashboard');
    }

    public function adminDashboard(){
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

}
