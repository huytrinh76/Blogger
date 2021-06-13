<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Toastr;
use App\Models\Subscriber;
class SubscriberController extends Controller
{
    public function index(){
        $subs = Subscriber::latest()->get();
        return view('admin.subscriber')->with('subs',$subs);
    }

    public function destroy($subscriber){
        $sub = Subscriber::findOrFail($subscriber);
        $sub->delete();
        Toastr::success('Dữ Liệu Xóa Thành Công','Success');
        return redirect()->back();  
    }
}
