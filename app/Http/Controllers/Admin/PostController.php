<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Toastr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AuthorPostApprove;
use App\Notifications\NewPostNotify;
use App\Models\Subscriber;
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
        $posts = Post::latest()->get();
        return view('admin.post.index')->with('posts',$posts);
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
        return view('admin.post.create')->with('categories',$categories)->with('tags',$tags);
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
        $post->is_approved = true;
        $post->save();
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);
        $subs = Subscriber::all();
        foreach($subs as $sub){
            if($post->status == true){
            Notification::route('mail',$sub->email)->notify(new NewPostNotify($post));
            }
        }
        Toastr::success('D??? Li???u T???o Th??nh C??ng','Success');
        return redirect()->route('admin.post.index');
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
        return view('admin.post.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post = Post::find($id);
        return view('admin.post.edit')->with('post',$post)->with('categories',$categories)->with('tags',$tags);
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
        $post = Post::find($id);
        if($request->file('image'))
        {
            $file = $request->file('image');
            @unlink(public_path('upload/post/'.$post->image));
            $currentDate = Carbon::now()->toDateString();
            $filename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalName();
            $file->move(public_path('upload/post'),$filename);
            $post->image = $filename;
        }
        $post->user_id = $post->user->id;
        $post->title = $request->title;
        $post->slug = $slug;
        $post->body = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);
        Toastr::success('D??? Li???u C???p Nh???t Th??nh C??ng','Success');
        return redirect()->route('admin.post.index');
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
        if(file_exists('upload/post/'.$post->image) AND  ! empty($post->image))
        {
            @unlink(public_path('upload/post/'.$post->image));
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('D??? Li???u X??a Th??nh C??ng','Success');
        return redirect()->route('admin.post.index');
    }

    public function pending(){
        $posts = Post::where('is_approved',false)->get();
        return view('admin.post.pending')->with('posts',$posts);
    }

    public function approve($id){
        $post = Post::find($id);
        if($post->is_approved == false){
            $post->is_approved = true;
            $post->save();
            $post->user->notify(new AuthorPostApprove($post));
            $subs = Subscriber::all();
            foreach($subs as $sub){
                if($post->status == true){
                    Notification::route('mail',$sub->email)->notify(new NewPostNotify($post));
                }
            }
            Toastr::success('D??? Li???u Approve Th??nh C??ng','Success');
        } else {
            Toastr::info('D??? Li???u ???? Approved','Success');
        }
        return redirect()->back();
    }
}
