@extends('layouts.backend.app')

@section('title','Kiểm duyệt bài viết')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <a href="{{ route('admin.post.create') }}" class="btn btn-primary waves-effect">
            <i class="material-icons">add</i>
            <span>Thêm bài viết</span>
        </a>
    </div>
    
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Danh sách bài viết
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
                                    <th>Tên người dùng</th>
                                    <th><i class="material-icons">visibility</i></th>
                                    <th>Duyệt bài</th>
                                    <th>Trạng thái</th>
                                    <th>Đã tạo vào lúc</th>
                                    <th>Đã cập nhật vào lúc</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $key=>$post )
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ Str::limit($post->title,10) }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>{{ $post->view_count }}</td>
                                        <td>
                                            @if($post->is_approved == true)
                                                <span class="badge bg-blue">Đã duyệt</span>
                                            @else
                                                <span class="badge bg-pink">Đang chờ</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($post->status == true)
                                                <span class="badge bg-green">Công khai</span>
                                            @else
                                                <span class="badge bg-grey">Riêng tư</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->created_at }}</td>
                                        <td>{{ $post->updated_at }}</td>
                                        <td class="text-center">
                                            @if ($post->is_approved == false)
                                                <button 
                                                    type="button" 
                                                    class="btn btn-warning waves-effect"
                                                    onclick="approvePost({{ $post->id }})"
                                                >
                                                    <i class="material-icons">done</i>
                                                </button>
                                                <form method="POST" action="{{ route('admin.post.approve',$post->id) }}" id="approve-form" style="display: none">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.post.show',$post->id) }}" class="btn btn-success waves-effect">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="{{ route('admin.post.edit',$post->id) }}" class="btn btn-info waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="btn btn-danger waves-effect" type="button" onclick="deletePost({{ $post->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="delete-form-{{ $post->id }}" action="{{ route('admin.post.destroy',$post->id) }}" method="post" style="display: none">
                                                @csrf
                                                @method('DELETE')
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
        function deletePost(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Thông Báo',
                text: "Thao tác này sẽ xóa bài viết!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng Ý',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Hủy Thành Công',
                        'Bài viết được giữ lại',
                        'error'
                    )
                }
            })
        }

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
                text: "Thao tác này sẽ duyệt bài viết!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng Ý',
                cancelButtonText: 'Hủy',
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
                        'Hủy Thành Công',
                        'Bài viết đã hủy duyệt',
                        'info'
                    )
                }
            })
        }
    </script>
@endpush
