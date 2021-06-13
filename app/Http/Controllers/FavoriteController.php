<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Auth;
class FavoriteController extends Controller
{
    public function add($post){
        $user = Auth::user();
        $isFavorite = $user->favorite_posts()->where('post_id',$post)->count();

        if($isFavorite == 0){
            $user->favorite_posts()->attach($post);
            Toastr::success('Like Post Thành Công','Success');
            return redirect()->back();
        } else {
            $user->favorite_posts()->detach($post);
            Toastr::success('Unlike Post Thành Công','Success');
            return redirect()->back();
        }
    }
}
