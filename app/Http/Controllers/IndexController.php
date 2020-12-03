<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
//        Auth::loginUsingId(1);
        return view('index');
    }
}
