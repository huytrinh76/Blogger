@extends('layouts.backend.app')

@section('title','Chỉnh sửa bài viết')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <form action="{{ route('admin.post.update',$post->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CHỈNH SỬA BÀI VIẾT
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="title" value="{{ $post->title }}">
                                <label class="form-label">Tiêu đề bài viết...</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="file" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <img id="showImage"
                             src="{{ !empty($post->image) ? url('upload/post/'.$post->image) : "" }}" 
                             alt="" 
                             style="width: 150px; height: 160px; border: 1px solid #000;">
                         </div>
                        <div class="form-group">
                            <input type="checkbox" name="status" id="publish" class="filled-in" value="1" {{ $post->status == true ? "checked" : "" }}>
                            <label for="publish">Công khai</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Danh Mục Và Thẻ
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('categories') ? "focused error" : ""}}">
                                <select name="categories[]" id="category" class="form-control show-tick" data-live-search="true" multiple title="Chọn danh mục">
                                    @foreach ($categories as $cate )
                                        <option 
                                            @foreach ($post->categories as $postCategory )
                                                {{ $postCategory->id == $cate->id ? "selected" : "" }}
                                            @endforeach
                                            value={{ $cate->id }} style="margin-left: 50px">{{ $cate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('tags') ? "focused error" : ""}}">
                                <select name="tags[]" id="tag" class="form-control show-tick" data-live-search="true" multiple title="Chọn thẻ">
                                    @foreach ($tags as $tag )
                                        <option
                                            @foreach ($post->tags as $postTag )
                                                {{ $postTag->id == $tag->id ? "selected" : "" }}
                                            @endforeach  
                                            value="{{ $tag->id }}" style="margin-left: 50px">{{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <a href="{{ route('admin.post.index') }}" class="btn btn-danger m-t-15 waves-effect">Quay lại</a>
                        <input type="submit" value="Lưu" class="btn btn-primary m-t-15 waves-effect"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            NỘI DUNG
                        </h2>
                    </div>
                    <div class="body">
                        <textarea id="tinymce" cols="30" rows="10" name="body">{{ $post->body }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Vertical Layout | With Floating Label -->
</div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
            $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
        })
    </script>
    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
     <!-- TinyMCE -->
    <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js') }}"></script>
    <script>
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('assets/backend/plugins/tinymce') }}';
        });
    </script>
@endpush