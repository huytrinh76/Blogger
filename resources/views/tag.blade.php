@extends('layouts.frontend.app')

@section('title','Thẻ')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/category/styles.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/category/responsive.css') }}">
    <style>
        .favorite_posts{
            color: green;
        }
    </style>
@endpush

@section('content')
<div class="slider display-table center-text">
    <h1 class="title display-table-cell"><b>{{ $tag->name }}</b></h1>
</div><!-- slider -->

<section class="blog-area section">
    <div class="container">

        <div class="row">
            @if ($posts->count() > 0)
                @foreach ($posts as $post )
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{ !empty($post->image) ? url('upload/post/'.$post->image) : ""  }}" alt="{{ $post->title }}"></div>

                                <a class="avatar" href="{{ route('author.profile',$post->user->username) }}"><img src="{{ asset('upload/profile/'.$post->user->image) }}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{ route('post.details',$post->slug) }}"><b>{{ $post->title }}</b></a></h4>

                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                                <a href="javascript:void(0);" onclick="toastr.info('Bạn Cần Đăng Nhập Để Thực Hiện Chức Năng Này','Info',{
                                                    closeButton:true,
                                                    progressBar:true,
                                                })">
                                                    <i class="ion-heart"></i>
                                                    {{ $post->favorite_to_users->count() }}
                                                </a>
                                            @else
                                                <a href="javascript:void(0);"
                                                    onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
                                                    class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count() == 0 ? 'favorite_posts' : '' }}">
                                                    <i class="ion-heart"></i>
                                                    {{ $post->favorite_to_users->count() }}
                                                </a>
                                                <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',$post->id) }}" style="display: none">
                                                    @csrf
                                                </form>
                                            @endguest 
                                        </li>
                                        <li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
                                        <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach
            @else
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="single-post post-style-1">                       
                        <div class="blog-info">
                            <h4 class="title">CHƯA CÓ POST NÀO THUỘC DANH MỤC NÀY !!!</h4>                       
                        </div><!-- blog-info -->
                    </div><!-- single-post -->
                </div><!-- card -->
            </div><!-- col-lg-4 col-md-6 -->
            @endif
           
            
        </div><!-- row -->


    </div><!-- container -->
</section><!-- section -->

@endsection

@push('js')
    
@endpush