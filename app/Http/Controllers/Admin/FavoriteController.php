<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
class FavoriteController extends Controller
{
    public function index(){
        // $b = Post::all();
        // $count = 0;
        // foreach($b as $c){
        //     if($c->favorite_to_users->count() != 0 ){
        //         $count++ ;
        //     }
        // }
        // return $count;
        $posts = Auth::user()->favorite_posts;
        return view('admin.favorite')->with('posts',$posts);

    }
}
