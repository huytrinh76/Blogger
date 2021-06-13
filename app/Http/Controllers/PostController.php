<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Toastr;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
class PostController extends Controller
{

    public function index(){
        $posts = Post::latest()->approved()->published()->paginate(6);
        return view('posts')->with('posts',$posts);
    }

    public function details($slug){
        $post = Post::where('slug',$slug)->approved()->published()->first();
        if(empty($post)){
            Toastr::warning('Post Không Tìm Thấy Hoặc Đã Bị Ẩn','Warning');
            return redirect()->back();
        }
        $blog_key = 'blog_'.$post->id;
        if(!Session::has($blog_key)){
            $post->increment('view_count');
            Session::put($blog_key,1);
        }
        $rand_posts = Post::approved()->published()->take(3)->inRandomOrder();
        return view('post')->with('post',$post)->with('rand_posts',$rand_posts);
    }

    public function postByCategory($slug){
        $category = Category::where('slug',$slug)->first();
        $posts = $category->posts()->approved()->published()->get();
        return view('category')->with('posts',$posts)->with('category',$category);
    }

    public function postByTag($slug){
        $tag = Tag::where('slug',$slug)->first();
        $posts = $tag->posts()->approved()->published()->get();
        return view('tag')->with('posts',$posts)->with('tag',$tag);
    }
}
