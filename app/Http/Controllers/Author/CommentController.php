<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
class CommentController extends Controller
{
    public function index(){
        $posts = Auth::user()->posts;
        return view('author.comments')->with('posts',$posts);
    }

    public function destroy($id){
        $c = Comment::findOrFail($id);
        if($c->post->user->id == Auth::user()->id){
            $c->delete();
        } else {
            Toastr::warning('Bạn Không Có Quyền Truy Cập','Warning');
            return redirect()->back();
        }
        Toastr::success('Dữ Liệu Xóa Thành Công','Success');
        return redirect()->back();
    }
}
