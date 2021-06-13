@extends('layouts.backend.app')

@section('title','Xem bài viết')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
        <a href="{{ route('admin.post.index') }}" class="btn btn-danger waves-effect">Quay lại</a>
        @if ($post->is_approved == false)
            <button type="button" class="btn btn-danger waves-effect pull-right"onclick="approvePost({{ $post->id }})">
                <i class="material-icons">pending</i>
                <span>Đang chờ</span>
            </button>
            <form method="POST" action="{{ route('admin.post.approve',$post->id) }}" id="approve-form" style="display: none">
                @csrf
                @method('PUT')
            </form>
        @else
            <button type="button" class="btn btn-success pull-right" disabled>
                <i class="material-icons">done</i>
                <span>Đã duyệt</span>
            </button>
        @endif
        <br><br>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ $post->title }}
                            <small>
                                Đã đăng bởi  
                                <strong>
                                    <a href="#">{{ $post->user->name }}</a>
                                </strong>vào {{ $post->created_at->toFormattedDateString() }}
                            </small>
                        </h2>
                    </div>
                    <div class="body">
                        {!! $post->body !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>
                            Danh mục
                        </h2>
                    </div>
                    <div class="body">
                        @foreach ($post->categories as $cate )
                            <span class="label bg-cyan">{{ $cate->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="header bg-green">
                        <h2>
                            Thẻ
                        </h2>
                    </div>
                    <div class="body">
                        @foreach ($post->tags as $tag )
                            <span class="label bg-green">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="header bg-amber">
                        <h2>
                            Ảnh
                        </h2>
                    </div>
                    <div class="body">
                        <img src="{{ !empty($post->image) ? url('upload/post/'.$post->image) : "" }}"  alt="" style="width: 150px;height:160px">
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
    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
     <!-- TinyMCE -->
    <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="text/javascript">
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

        function approvePost(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Thông Báo',
                text: "Thao Tác Này Sẽ Duyệt Bài viết!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng Ý',
                cancelButtonText: 'Hủy Thao Tác',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('approve-form').submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Hủy Thao Tác Thành Công',
                        'Bài viết đã hủy duyệt',
                        'info'
                    )
                }
            })
        }
    </script>
@endpush