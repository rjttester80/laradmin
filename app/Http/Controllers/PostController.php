<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function postsDashboard(Request $request){
        return view('user.postsDashboard');

    }
}
