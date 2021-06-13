@extends('layouts.frontend.app')

@section('title')
    {{ $post->title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/single-post/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/single-post/responsive.css') }}">
    <style>
        .header-bg{
            height: 400px;
            width: 100%;
            background-image: url({{ !empty($post->image) ? url('upload/post/'.$post->image) : ""  }});
            background-size: 1550px 400px;
        }
        .favorite_posts{
            color: green;
        }
    </style>
@endpush

@section('content')
<div class="header-bg">
    
</div><!-- slider -->

<section class="post-area section">
    <div class="container">

        <div class="row">

            <div class="col-lg-8 col-md-12 no-right-padding">

                <div class="main-post">

                    <div class="blog-post-inner">

                        <div class="post-info">

                            <div class="left-area">
                                <a class="avatar" href="{{ route('author.profile',$post->user->username) }}"><img src="{{ !empty($post->user->image) ? url('upload/profile/'.$post->user->image) : ""  }}" alt="Profile Image"></a>
                            </div>

                            <div class="middle-area">
                                <a class="name" href="{{ route('author.profile',$post->user->username) }}"><b>{{ $post->user->name }}</b></a>
                                <h6 class="date">on {{ $post->created_at->diffForHumans() }}</h6>
                            </div>

                        </div><!-- post-info -->

                        <h3 class="title"><a href="#"><b>{{ $post->title }}</b></a></h3>

                        <p class="para">
                            {!! html_entity_decode($post->body) !!}
                        </p>


                        <ul class="tags">
                            @foreach ($post->tags as $tag )
                                <li><a href="{{ route('tags.post',$tag->slug) }}">{{ $tag->name }}</a></li> 
                            @endforeach
                        </ul>
                    </div><!-- blog-post-inner -->

                    <div class="post-icons-area">
                        <ul class="post-icons">
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

                        <ul class="icons">
                            <li>SHARE : </li>
                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                            <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                        </ul>
                    </div>

                    


                </div><!-- main-post -->
            </div><!-- col-lg-8 col-md-12 -->

            <div class="col-lg-4 col-md-12 no-left-padding">

                <div class="single-post info-area">

                    <div class="sidebar-area about-area">
                        <h4 class="title"><b>Mô tả người dùng</b></h4>
                        <p>{{ $post->user->about }}</p>
                    </div>


                    <div class="tag-area">

                        <h4 class="title"><b>Danh mục</b></h4>
                        <ul>
                            @foreach ($post->categories as $cate )
                                <li><a href="{{ route('category.posts',$cate->slug) }}">{{ $cate->name }}</a></li> 
                            @endforeach
                        </ul>

                    </div><!-- subscribe-area -->

                </div><!-- info-area -->

            </div><!-- col-lg-4 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section><!-- post-area -->


<section class="recomended-area section">
    <div class="container">
        <div class="row">
            @foreach ($rand_posts as $r_post )
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="single-post post-style-1">

                            <div class="blog-image"><img src="{{ !empty($r_post ->image) ? url('upload/post/'.$r_post ->image) : ""  }}" alt="{{ $r_post ->title }}" style="height:200px;"></div>

                            <a class="avatar" href="#"><img src="{{ asset('upload/profile/'.$r_post ->user->image) }}" alt="Profile Image"></a>

                            <div class="blog-info">

                                <h4 class="title"><a href="{{ route('post.details',$r_post ->slug) }}"><b>{{ $r_post ->title }}</b></a></h4>

                                <ul class="post-footer">
                                    <li>
                                        @guest
                                            <a href="javascript:void(0);" onclick="toastr.info('Bạn Cần Đăng Nhập Để Thực Hiện Chức Năng Này','Info',{
                                                closeButton:true,
                                                progressBar:true,
                                            })">
                                                <i class="ion-heart"></i>
                                                {{ $r_post ->favorite_to_users->count() }}
                                            </a>
                                        @else
                                            <a href="javascript:void(0);"
                                                onclick="document.getElementById('favorite-form-{{ $r_post ->id }}').submit();"
                                                class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$r_post ->id)->count() == 0 ? 'favorite_posts' : '' }}">
                                                <i class="ion-heart"></i>
                                                {{ $r_post ->favorite_to_users->count() }}
                                            </a>
                                            <form id="favorite-form-{{ $r_post ->id }}" method="POST" action="{{ route('post.favorite',$r_post ->id) }}" style="display: none">
                                                @csrf
                                            </form>
                                        @endguest 
                                    </li>
                                    <li><a href="#"><i class="ion-chatbubble"></i>{{ $r_post->comments->count() }}</a></li>
                                    <li><a href="#"><i class="ion-eye"></i>{{ $r_post->view_count }}</a></li>
                                </ul>

                            </div><!-- blog-info -->
                        </div><!-- single-post -->
                    </div><!-- card -->
                </div><!-- col-lg-4 col-md-6 -->
            @endforeach
        </div><!-- row -->

    </div><!-- container -->
</section>

<section class="comment-section">
    <div class="container">
        <h4><b>BÌNH LUẬN BÀI VIẾT</b></h4>
        <div class="row">

            <div class="col-lg-8 col-md-12">
                <div class="comment-form">
                    @guest
                        <p>Đăng nhập để được bình luận bài viết . <a href="{{ route('login') }}" style="color: blue">Đăng nhập</a></p>
                    @else
                        <form method="POST" action="{{ route('comment.store',$post->id) }}">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <textarea name="comment" rows="2" class="text-area-messge form-control"
                                        placeholder="Nhập điều bạn muốn bình luận" aria-required="true" aria-invalid="false"></textarea >
                                </div><!-- col-sm-12 -->
                                <div class="col-sm-12">
                                    <button class="submit-btn" type="submit" id="form-submit"><b>Bình luận</b></button>
                                </div><!-- col-sm-12 -->

                            </div><!-- row -->
                        </form>
                    @endguest
                </div><!-- comment-form -->

                <h4><b>BÌNH LUẬN({{ $post->comments->count() }})</b></h4>
                    @foreach ($post->comments->sortByDesc('created_at') as $c )
                        <div class="commnets-area ">

                            <div class="comment">

                                <div class="post-info">

                                    <div class="left-area">
                                        <a class="avatar" href="#"><img src="{{ !empty($c->user->image) ? url('upload/profile/'.$c->user->image) : ""  }}" alt="Profile Image"></a>
                                    </div>

                                    <div class="middle-area">
                                        <a class="name" href="#"><b>{{ $c->user->name }}</b></a>
                                        <h6 class="date">on {{ $c->created_at->diffForHumans() }}</h6>
                                    </div>

                                </div><!-- post-info -->

                                <p>{{ $c->comment }}</p>

                            </div>

                        </div><!-- commnets-area -->
                    @endforeach
            </div><!-- col-lg-8 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section>
@endsection

@push('js')
    
@endpush