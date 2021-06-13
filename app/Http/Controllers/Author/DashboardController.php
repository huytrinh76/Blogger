<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index(){

        $user = Auth::user();
        $posts = $user->posts;
        $count = 0;
        foreach($posts as $p){
            $count +=  $p->favorite_to_users->count();
        }
        $popular_posts = $user->posts()
        ->withCount('comments')
        ->withCount('favorite_to_users')
        ->orderBy('view_count','desc')
        ->orderBy('comments_count')
        ->orderBy('favorite_to_users_count')
        ->take(5)->get();
        $total_pending_posts = $posts->where('is_approved',false)->count();
        $all_view = $posts->sum('view_count');
        return view('author.dashboard')->with('posts',$posts)->with('popular_posts',$popular_posts)->with('total_pending_posts',$total_pending_posts)
        ->with('all_view',$all_view)->with('count',$count);
    }
}
