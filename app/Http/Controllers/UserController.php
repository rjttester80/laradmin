<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function loadRegister(){
        if(Auth::user() && Auth::user()->is_admin==1){
            return redirect('/admin/dashboard');
        }else if(Auth::user() && Auth::user()->is_admin==0){
            return redirect('/dashboard');
        }
        return view('user.register');
    }

    public function userRegister(Request $request){
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

    }

    public function loadLogin(){
        if(Auth::user() && Auth::user()->is_admin==1){
            return back()->with('error', 'Access Denied!');
        }else if(Auth::user() && Auth::user()->is_admin==0){
            return redirect('/dashboard');
        }
        return view('user.login');
    }

    public function userLogin(Request $request){
        //dd($request->all());
        $request->validate([
            'email'=>'email|required',
            'password'=>'required|min:6'
        ]);

        $userCred = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if($user->is_admin == 0 && $user->status == 0){
            return back()->with('error', 'Your Account is diabled!');
        }
        if($user->is_admin == 1){
            return back()->with('error', 'Access Denied!');
        }
        if(Auth::attempt( $userCred )){
                return redirect('/dashboard');

        }
         else{
            return back()->with('error', 'Username & Password is incorrect!');
        }
    }

    public function loadDashboard(){
        return view('user.dashboard');
    }

    public function contact(){
        return view('user.contact');
    }

    public function forgotPassword(){
        //dd("hello");
        return view('user.forgotpassword');
    }

    public function forgetPassword(Request $request){
        try{
            $user = User::where('email',$request->email)->get();

        if(count($user)>0){
            $token = Str::random(40);
            $domain = URL::to('/');
            $url = $domain.'/reset-password?token='.$token;

            $data['url'] = $url;
            $data['email'] = $request->email;
            $data['title'] = 'Password Reset';
            $data['body'] =  'Please click on below link to reset your password!';

            Mail::send('forgetPasswordMail', ['data'=>$data], function($message) use($data){
                $message->to($data['email'])->subject($data['title']);
            });

            $dataTime = Carbon::now()->format('Y-m-d H:i:s');

            PasswordReset::updateOrCreate(
                ['email'=>$request->email],
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at'=> $dataTime
                ]
            );

            return back()->with('success', 'Please check your mail to reset your password!');

        }
        else{
            return back()->with('error', 'Email not exists!');
        }

        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }

    public function resetPasswordLoad(Request $request){
        $resetData = PasswordReset::where('token',$request->token)->first();
        //dd($resetData->email);
        if(isset($request->token) && $resetData){
            $user = User::where('email', $resetData->email)->first();//dd($user);
            return view('resetPassword', compact('user'));
        }else{
            return view('404');
        }
    }

    public function resetPassword(Request $request){
        //dd($request->all());
        $request->validate([
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password|min:6'
        ]);

        $user = User::find($request->id);//dd($user);
        $user->password = Hash::make($request->password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return redirect('/user-login')->with('success', 'Password reset successfully!');
    }

    public function loginGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function gloginCallback(){
        try {
            $user = Socialite::driver('google')->user();

            $is_user = User::where('email', $user->getEmail())->first();

            if(!$is_user){
                User::updateOrCreate(
                    [
                        'google_id' => $user->getId(),
                    ],
                    [
                        'name'=>$user->getName(),
                        'email'=>$user->getEmail(),
                        'password'=>Hash::make($user->getName().'@'.$user->getId()),
                    ]
                );
            }else{
                $saveUser = User::where('email', $user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);

                $saveUser = User::where('email', $user->getEmail())->first();

            }
            Auth::loginUsingId($saveUser->id);
            return redirect()->route('dashboard');

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function loginGithub(){
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(){
        try {
            $user = Socialite::driver('github')->user();

            $is_user = User::where('email', $user->getEmail())->first();

            if(!$is_user){
                User::updateOrCreate(
                    [
                        'github_id' => $user->getId(),
                    ],
                    [
                        'name'=>$user->getName(),
                        'email'=>$user->getEmail(),
                        'password'=>Hash::make($user->getName().'@'.$user->getId()),
                    ]
                );
            }else{
                $saveUser = User::where('email', $user->getEmail())->update([
                    'github_id' => $user->getId(),
                ]);

                $saveUser = User::where('email', $user->getEmail())->first();

            }
            Auth::loginUsingId($saveUser->id);
            return redirect()->route('dashboard');

        } catch (\Throwable $th) {
            throw $th;
        }

    }

}
