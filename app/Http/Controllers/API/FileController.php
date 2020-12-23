<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndexResource;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function post(Request $request) {
//        dump($request->file());
        return new IndexResource(['id' => 111, 'name' => 'Test file 12345', 'size' => 999, 'file' => ['size' => 999]]);
    }
}
