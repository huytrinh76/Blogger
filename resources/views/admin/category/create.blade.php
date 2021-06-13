@extends('layouts.backend.app')

@section('title','Tạo danh mục')

@push('css')
    
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        TẠO DANH MỤC
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="name">
                                <label class="form-label">Tên danh mục...</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="file" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <img id="showImage" 
                             alt="" 
                             style="width: 150px; height: 160px; border: 1px solid #000;">
                         </div>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-danger m-t-15 waves-effect">Quay lại</a>
                        <input type="submit" value="Lưu" class="btn btn-primary m-t-15 waves-effect"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
@endpush