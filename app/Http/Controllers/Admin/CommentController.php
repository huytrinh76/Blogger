<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Toastr;
use App\Models\Comment;
class CommentController extends Controller
{
    public function index(){
        $comments = Comment::latest()->get();
        return view('admin.comments')->with('comments',$comments);
    }

    public function destroy($id){
        $c = Comment::findOrFail($id);
        $c->delete();
        Toastr::success('Dữ Liệu Xóa Thành Công','Success');
        return redirect()->back();
    }
}
