<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Toastr;
use App\Models\Subscriber;
class SubscriberController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'email'=>'required|unique:subscribers,email',
        ]);
        $sub = new Subscriber;
        $sub->email = $request->email;
        $sub->save();
        Toastr::success('You successfully added to our subscriber list','Success');
        return redirect()->back();
    }
}
