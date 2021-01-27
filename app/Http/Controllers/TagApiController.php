<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagApiController extends Controller
{
    //
    public function list(Request $request)
    {


        return [
            'success' => true,
            'data' => Tag::query()->select('id', 'name')->get()->toArray()
        ];
    }
}
