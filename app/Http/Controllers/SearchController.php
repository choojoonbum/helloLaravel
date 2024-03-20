<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SearchRequest $request)
    {
        $query = $request->input('query');

        return view('search', [
            'posts' => Post::search($query)->get(),
            'query' => $query
        ]);
    }
}
