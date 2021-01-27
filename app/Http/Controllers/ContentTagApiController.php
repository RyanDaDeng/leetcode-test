<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Tag;
use App\Models\TagContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentTagApiController extends Controller
{
    //

    public function list(Request $request)
    {
        $tagId = $request->query('tag_id');
        $contentIds = TagContent::query()->where('tag_id', $tagId)->pluck('content_id');

        $contents = Content::query()->select('id', 'name')->whereIn('id', $contentIds)->get();

        return [
            'success' => true,
            'data' =>$contents
        ];
    }


    public function popularTag(Request $request)
    {

        $data = TagContent::query()
            ->select(DB::raw('count(*) as tag_count, tag_id'))
            ->groupBy('tag_id')
            ->orderBy('tag_count', 'desc')
            ->limit(5)
            ->get();

        return [
            'success' => true,
            'data' => $data->toArray()
        ];
    }
}
