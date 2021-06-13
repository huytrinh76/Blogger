<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
class DashboardController extends Controller
{
    public function index(){
        $posts = Post::all();
        $count = 0;
        foreach($posts as $post){
            $count += $post->favorite_to_users->count();
        }
        $popular_posts = Post::withCount('comments')
                            ->withCount('favorite_to_users')
                            ->orderBy('view_count','desc')
                            ->orderBy('comments_count','desc')
                            ->orderBy('favorite_to_users_count','desc')
                            ->take(5)->get();
        $total_pending_posts = Post::where('is_approved',false)->count();
        $all_views = Post::sum('view_count');
        $author_count = User::where('role_id',2)->count();
        $new_authors_today = User::where('role_id',2)
                                ->whereDate('created_at',Carbon::today())->count();
        $active_authors = User::where('role_id',2)
                                ->withCount('posts')
                                ->withCount('comments')
                                ->withCount('favorite_posts')
                                ->orderBy('posts_count','desc')
                                ->orderBy('comments_count','desc')
                                ->orderBy('favorite_posts_count','desc')
                                ->take(10)->get();
       $category_count = Category::all()->count();
       $tag_count = Tag::all()->count();
       return view('admin.dashboard')->with('posts',$posts)->with('popular_posts',$popular_posts)->with('total_pending_posts',$total_pending_posts)
       ->with('all_views',$all_views)->with('author_count',$author_count)->with('new_authors_today',$new_authors_today)->with('active_authors',$active_authors)
       ->with('category_count',$category_count)->with('tag_count',$tag_count)->with('count',$count);
    }
}
