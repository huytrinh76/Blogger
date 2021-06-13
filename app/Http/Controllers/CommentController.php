<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
class CommentController extends Controller
{
    public function store(Request $request, $post){
       $this->validate($request,[
           'comment'=>'required',
       ]);
       $comment = new Comment;
       $comment->user_id = Auth::user()->id;
       $comment->post_id = $post;
       $comment->comment = $request->comment;
       $comment->save();
       Toastr::success('Comment Thành Công','Success');
       return redirect()->back();
    }
}
