<?php

namespace App\Http\Controllers;

use App\Http\Resources\IndexResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            return view('index');
        } else {
            return view('login');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return new IndexResource([
                'success' => true,
            ]);
        }

        return new IndexResource([
            'success' => false,
            'errors' => [
                400 => 'Login or password is incorrect',
            ]
        ]);

    }
}
