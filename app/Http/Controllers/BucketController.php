<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BucketController extends Controller
{
    public function index(Request $request): View
    {
        $model = Bucket::query()
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('bucket.index', ['model' => $model]);
    }

    public function edit(Request $request, int $id): View
    {
        $model = Bucket::query()
            ->with('files.file')
            ->find($id);

        return view('bucket.edit', ['model' => $model]);
    }
}
