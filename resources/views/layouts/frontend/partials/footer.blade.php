<footer>
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">

                    {{-- <a class="logo" href="#"><img src="images/logo.png" alt="Logo Image"></a> --}}
                    <p class="copyright">Blog @ 2021. Bản quyền đã được đăng ký.</p>
                    <p class="copyright">Thiết kế bởi <a href="#">HieuK</a>. Phát triển và nghiên cứu bởi <a href="#">Nhóm 8</a>.</p>
                    <ul class="icons">
                        <li><a href="#"><i class="ion-social-facebook-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-twitter-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-vimeo-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-pinterest-outline"></i></a></li>
                    </ul>

                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

            <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                    <h4 class="title"><b>THỂ LOẠI</b></h4>
                    <ul>
                        @foreach ($categories as $cate )
                            <li><a href="{{ route('category.posts',$cate->slug) }}">{{ $cate->name }}</a></li>
                        @endforeach     
                    </ul>
                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

            <div class="col-lg-4 col-md-6">
                <div class="footer-section">

                    <h4 class="title"><b>Đăng ký nhận tin tức</b></h4>
                    <div class="input-area">
                        <form method="POST" action="{{ route('subscriber.store') }}">
                            @csrf
                            <input class="email-input" name="email" type="email" placeholder="Nhập email của bạn">
                            
                            <button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
                        </form>
                    </div>

                </div><!-- footer-section -->
            </div><!-- col-lg-4 col-md-6 -->

        </div><!-- row -->
    </div><!-- container -->
</footer>