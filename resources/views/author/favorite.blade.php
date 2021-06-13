@extends('layouts.backend.app')

@section('title','Bài viết yêu thích')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Danh sách bài viết yêu thích
                        <span class="badge bg-info">{{ $posts->count() }}</span>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Người dùng</th>
                                    <th><i class="material-icons">favorite</i></th>
                                    {{-- <th><i class="material-icons">comment</i></th> --}}
                                    <th><i class="material-icons">visibility</i></th>
                                    <th>Hành sđộng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $key=>$post )
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ Str::limit($post->title,10) }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>{{ $post->favorite_to_users->count() }}</td>
                                        <td>{{ $post->view_count }}</td>
                                        <td class="text-center">
                                           
                                            <a href="{{ route('admin.post.show',$post->id) }}" class="btn btn-success waves-effect">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                           
                                            <button class="btn btn-danger waves-effect" type="button" onclick="removePost({{ $post->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="remove-form-{{ $post->id }}" action="{{ route('post.favorite',$post->id) }}" method="post" style="display: none">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</div>
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="text/javascript">
        function removePost(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Thông Báo',
                text: "Thao tác này sẽ xóa lượt yêu thích!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng Ý',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('remove-form-'+id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Hủy Thành Công',
                        'Lượt yêu thích được giữ lại',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
