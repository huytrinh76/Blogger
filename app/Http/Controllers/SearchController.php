<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class SearchController extends Controller
{
    public function search(Request $request){
        $query = $request->input('query');
        $posts = Post::where('title','LIKE','%'.$query.'%')->approved()->published()->get();
        return view('search')->with('query',$query)->with('posts',$posts);
    }
}
