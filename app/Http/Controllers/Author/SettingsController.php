<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class SettingsController extends Controller
{
    public function index(){
        return view('author.settings');
    }

    public function updateProfile(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'image'=>'required|mimes:png,jpg,jpeg'
        ]);
        $slug = Str::slug($request->name);
        $user = User::findOrFail(Auth::id());
        if($request->file('image'))
        {
            $file = $request->file('image');
            @unlink(public_path('upload/profile/'.$user->image));
            $currentDate = Carbon::now()->toDateString();
            $filename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalName();
            $file->move(public_path('upload/profile'),$filename);
            $user->image = $filename;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->about = $request->about;
        $user->save();
        Toastr::success('Dữ Liệu Cập Nhật Thành Công','Success');
        return redirect()->back();
    }


    public function updatePassword(Request $request){
        $this->validate($request,[
            'old_password'=>'required',
            'password'=>'required|min:6|confirmed',
        ]);
        $hasedpass = Auth::user()->password;
        if(Hash::check($request->old_password,$hasedpass)){
            if(!Hash::check($request->password,$hasedpass)) {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Đổi Mật Khẩu Thành Công','Success');
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('Mật Khẩu Mới Phải Khác Mật Khẩu Cũ','Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Mật Khẩu Hiện Tại Không Đúng','Error');
            return redirect()->back();
        }
    }
}
