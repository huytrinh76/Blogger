<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Toastr;
use App\Models\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index')->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name'=>'required|unique:categories,name',
            'image'|'mimes:png,jpg,jpeg',
        ]);
        $category = new Category;
        $slug = Str::slug($request->name);
        if($request->file('image'))
        {
            $file = $request->file('image');
            $currentDate = Carbon::now()->toDateString();
            $filename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalName();
            $file->move(public_path('upload/category'),$filename);
            copy(public_path('upload/category/'.$filename), public_path('upload/category/slider/'.$filename));
            $category->image = $filename;
        }
        $category->name=$request->name;
        $category->slug=$slug;
        $category->save();
        Toastr::success('Dữ Liệu Tạo Thành Công','Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit')->with('category',$category);
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
            'name'=>[
                'required',
                Rule::unique('categories')->ignore($id)
            ],
            'image'|'mimes:png,jpg,jpeg',
        ]);
        $category = Category::find($id);
        $slug = Str::slug($request->name);
        if($request->file('image'))
        {
            $file = $request->file('image');
            @unlink(public_path('upload/category/'.$category->image));
            @unlink(public_path('upload/category/slider/'.$category->image));
            $currentDate = Carbon::now()->toDateString();
            $filename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalName();
            $file->move(public_path('upload/category'),$filename);
            copy(public_path('upload/category/'.$filename), public_path('upload/category/slider/'.$filename)); 
            $category->image = $filename;
        }
        $category->name=$request->name;
        $category->slug=$slug;
        $category->save();
        Toastr::success('Dữ Liệu Cập Nhật Thành Công','Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(file_exists('upload/category/'.$category->image) AND  ! empty($category->image))
        {
            @unlink(public_path('upload/category/'.$category->image));
        }
        if(file_exists('upload/category/slider/'.$category->image) AND  ! empty($category->image))
        {
            @unlink(public_path('upload/category/slider/'.$category->image));
        }
        $category->delete();
        Toastr::success('Dữ Liệu Xóa Thành Công','Success');
        return redirect()->route('admin.category.index');
    }
}
