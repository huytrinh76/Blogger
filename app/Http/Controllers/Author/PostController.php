<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Toastr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAuthorPost;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.post.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.create')->with('categories',$categories)->with('tags',$tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|unique:posts,title',
            'image'=>'required|mimes:png,jpg,jpeg',
            'categories'=>'required',
            'tags'=>'required',
            'body'=>'required',
        ]);
        $slug = Str::slug($request->title);
        $post = new Post;
        if($request->file('image'))
        {
            $file = $request->file('image');
            $currentDate = Carbon::now()->toDateString();
            $filename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalName();
            $file->move(public_path('upload/post'),$filename);
            $post->image = $filename;
        }
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->slug = $slug;
        $post->body = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);
        $users = User::where('role_id',1)->get();
        Notification::send($users, new NewAuthorPost($post));
        Toastr::success('Dữ Liệu Tạo Thành Công','Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if($post->user_id != Auth::user()->id)
        {
            Toastr::warning('Bạn Không Có Quyền Truy Cập','Warning');
            return redirect()->back();
        }
        return view('author.post.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if($post->user_id != Auth::user()->id)
        {
            Toastr::warning('Bạn Không Có Quyền Truy Cập','Warning');
            return redirect()->back();
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit')->with('post',$post)->with('categories',$categories)->with('tags',$tags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if($post->user_id != Auth::user()->id)
        {
            Toastr::warning('Bạn Không Có Quyền Truy Cập','Warning');
            return redirect()->back();
        }
        $this->validate($request,[
            'title'=>[
                'required',
                Rule::unique('posts')->ignore($id)
            ],
            'image'=>'mimes:png,jpg,jpeg',
            'categories'=>'required',
            'tags'=>'required',
            'body'=>[
                'required',
                Rule::unique('posts')->ignore($id)
            ],
        ]);
        $slug = Str::slug($request->title);
        if($request->file('image'))
        {
            $file = $request->file('image');
            @unlink(public_path('upload/post/'.$post->image));
            $currentDate = Carbon::now()->toDateString();
            $filename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalName();
            $file->move(public_path('upload/post'),$filename);
            $post->image = $filename;
        }
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->slug = $slug;
        $post->body = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);
        Toastr::success('Dữ Liệu Cập Nhật Thành Công','Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post->user_id != Auth::user()->id)
        {
            Toastr::warning('Bạn Không Có Quyền Truy Cập','Warning');
            return redirect()->back();
        }
        if(file_exists('upload/post/'.$post->image) AND  ! empty($post->image))
        {
            @unlink(public_path('upload/post/'.$post->image));
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Dữ Liệu Xóa Thành Công','Success');
        return redirect()->route('author.post.index');
    }
}
