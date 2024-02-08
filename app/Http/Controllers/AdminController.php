<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\SendMail;
use GuzzleHttp\Psr7\Query;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(User::select('*'))
            ->addColumn('action', 'user-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.usersDashboard');
    }

    public function usersDashboard(Request $request){
        $query = User::query();

        if($request->ajax()){
            $users = $query->where('name','LIKE','%'.$request->search.'%')
            ->orWhere('email','LIKE','%'.$request->search.'%')
            ->orWhere('created_at','LIKE','%'.$request->search.'%')
            ->get();
            return response()->json(['users'=>$users]);

        } else {
        $users = User::where('is_admin', 0)
        ->orderBy('created_at', 'desc')
        ->paginate(6);
        return view('admin.usersDashboard', compact('users'));
        }
    }

    public function usersCreated(){
        $users = User::where('is_admin', 0)->get();
        return view('admin.usersCreated', compact('users'));
    }

    public function trashed(){
        $tusers = User::onlyTrashed()->get();
        return view('admin.trashed', compact('tusers'));
    }

    public function addUser(Request $request){
        try {
            $file = $request->file('image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $filePath = $file->storeAs('images', $fileName);
            $password = Str::random(8);
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'image'=>$filePath,
                'password'=>Hash::make($password)
            ]);
            $uuser = $user->toArray();
            $uuser['passwordx']=$password;
            Event::dispatch(new SendMail($uuser));
            /* $url = URL::to('/');
            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = $password;
            $data['title'] = 'New User Registration';

            Mail::send('registrationMail', ['data'=>$data], function ($message) use ($data) {
                $message->to($data['email']);                $message->subject($data['title']);
            }); */
            return response()->json(['success'=>true,'msg'=>'User added successfully!!!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function editUser(Request $request){
        try {

            $fileName = '';
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->new_password != ''){
                $user->password = Hash::make($request->new_password);
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time().'.'.$file->getClientOriginalExtension();
                $user->image = $file->storeAs('images', $fileName);
            }
            $user->save();

            $url = URL::to('/user-login');
            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            if($request->new_password != ''){
                $data['password'] = $request->new_password;
            }
            $data['title'] = 'User Profile Updated';

            Mail::send('updateProfileMail', ['data'=>$data], function ($message) use ($data) {
                $message->to($data['email']);
                $message->subject($data['title']);
            });
            return response()->json(['success'=>true,'msg'=>'User updated successfully!!!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function deleteUser(Request $request){
        try {
            $duser=User::withTrashed()->where('id',$request->id);
            if(!is_null($duser)){
                $duser->forceDelete();
            }
            return response()->json(['success'=>true,'msg'=>'User deleted successfully!!!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function trashUser(Request $request){
        try {
            User::where('id',$request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'User deleted successfully!!!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function restoreUser(Request $request){
        try {
        $restoreDataId = User::withTrashed()->where('id',$request->id);
        if(!is_null($restoreDataId)){
            $restoreDataId->restore();
        }
        return response()->json(['success'=>true,'msg'=>'User restored successfully!!!']);
    } catch (\Exception $e) {
        return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
    }

}
    public function searchUser(){
        $users = User::all();
        return view('admin.searchUser', compact('users'));
    }

    public function showChart(){
        $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                    ->whereYear("created_at", date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('count', 'month_name');

        $labels = $users->keys();//dd($labels);
        $data = $users->values();//dd($data);

        return view('admin.chart', compact('labels', 'data'));
    }

    public function changeStatus(Request $request){
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success', 'Status Changed Successfull!']);

    }

    public function monthData(Request $request){
        $request->validate(['month' => 'required']);
        $users = User::query()
            ->whereMonth('created_at', Carbon::parse($request->month)->format('m'))
            ->whereYear('created_at', Carbon::parse($request->month)->format('Y'))
            ->get();
            return response()->json(['users'=>$users]);
    }


}
