<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Toastr;
use App\Models\User;
class AuthorController extends Controller
{
    public function index(){
        $authors = User::authors()
        ->withCount('posts')
        ->withCount('comments')
        ->withCount('favorite_posts')
        ->get();
        return view('admin.authors')->with('authors',$authors);
    }

    public function destroy($id){
        $author = User::findOrFail($id);
        $all_post_user = $author->posts;
        foreach($all_post_user as $al){
            $al->favorite_to_users()->detach();
            $al->tags()->detach();
            $al->categories()->detach();
            if(file_exists('upload/post/'.$al->image) AND  ! empty($al->image))
            {
                @unlink(public_path('upload/post/'.$al->image));
            }
        }
        if(file_exists('upload/profile/'.$author->image) AND  ! empty($author->image))
        {
            @unlink(public_path('upload/profile/'.$author->image));
        }
        $author->favorite_posts()->detach();
        $author->delete();
        Toastr::success('Author Successfully Deleted','Success');
        return redirect()->back();
    }

}
