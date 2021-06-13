@extends('layouts.backend.app')

@section('title','Bảng điều khiển')

@push('css')
    
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>BẢNG ĐIỀU KHIỂN</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">playlist_add_check</i>
                </div>
                <div class="content">
                    <div class="text">TẤT CẢ BÀI VIẾT</div>
                    <div class="number count-to" data-from="0" data-to="{{ $posts->count() }}" data-speed="15" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">favorite</i>
                </div>
                <div class="content">
                    <div class="text">SỐ LƯỢT YÊU THÍCH</div>
                    <div class="number count-to" data-from="0" data-to="{{ $count }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">forum</i>
                </div>
                <div class="content">
                    <div class="text">BÀI VIẾT CHỜ XỬ LÝ</div>
                    <div class="number count-to" data-from="0" data-to="{{ $total_pending_posts }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="content">
                    <div class="text">TỔNG NGƯỜI XEM BÀI</div>
                    <div class="number count-to" data-from="0" data-to="{{ $all_view }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->  
    <div class="row clearfix">
        <!-- Task Info -->
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="header">
                    <h2>TOP 5 BÀI VIẾT ĐƯỢC YÊU THÍCH</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                                <tr>
                                    <th>HẠNG</th>
                                    <th>TIÊU ĐỀ</th>
                                    <th>LƯỢT XEM</th>
                                    <th>LƯỢT THÍCH</th>
                                    <th>BÌNH LUẬN</th>
                                    <th>TRẠNG THÁI</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($popular_posts as $key=>$post )
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ Str::limit($post->title,30) }}</td>
                                    <td><span class="label bg-green">{{ $post->view_count }}</span></td>
                                    <td>{{ $post->favorite_to_users_count }}</td>
                                    <td>{{ $post->comments_count }}</td>
                                    <td>
                                        @if ($post->status == true)
                                            <span class="label bg-green">Công Khai</span>
                                        @else
                                            <span class="label bg-grey">Riêng tư</span>
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Task Info -->
    </div>
</div>
@endsection

@push('js')
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-countto/jquery.countTo.js') }}"></script>
 
    <script src="{{ asset('assets/backend/js/pages/index.js') }}"></script>
@endpush
