<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ asset('upload/profile/'.Auth::user()->image) }}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</div>
            <div class="email">{{ Auth::user()->email }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="{{ Auth::user()->role->id == 1 ? route('admin.settings') : route('author.settings') }}">
                            <i class="material-icons">settings</i>
                            Cài đặt
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i>Đăng xuất
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">CÁC TÁC VỤ CHÍNH</li>
            @if (Request::is('admin*'))
                <li class="{{ Request::is('admin/dashboard') ? 'active' : "" }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="material-icons">dashboard</i>
                        <span>Bảng điều khiển</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/tag*') ? 'active' : "" }}">
                    <a href="{{ route('admin.tag.index') }}">
                        <i class="material-icons">label</i>
                        <span>Thẻ</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/category*') ? 'active' : "" }}">
                    <a href="{{ route('admin.category.index') }}">
                        <i class="material-icons">category</i>
                        <span>Danh Mục</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/post*') ? 'active' : "" }}">
                    <a href="{{ route('admin.post.index') }}">
                        <i class="material-icons">library_books</i>
                        <span>Bài viết</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/pending/post') ? 'active' : "" }}">
                    <a href="{{ route('admin.post.pending') }}">
                        <i class="material-icons">library_books</i>
                        <span>Bài viết đang chờ duyệt</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/favorite') ? 'active' : "" }}">
                    <a href="{{ route('admin.favorite.index') }}">
                        <i class="material-icons">favorite</i>
                        <span>Bài viết yêu thích</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/subscriber') ? 'active' : "" }}">
                    <a href="{{ route('admin.subscriber.index') }}">
                        <i class="material-icons">subscriptions</i>
                        <span>Người đăng ký</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/authors') ? 'active' : "" }}">
                    <a href="{{ route('admin.author.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span>Người dùng</span>
                    </a>
                </li>
                <li class="{{ Request::is('admin/comments') ? 'active' : "" }}">
                    <a href="{{ route('admin.comment.index') }}">
                        <i class="material-icons">comment</i>
                        <span>Bình luận</span>
                    </a>
                </li>
            <li class="header">System</li>
                <li class="{{ Request::is('admin/settings') ? 'active' : "" }}">
                    <a href="{{ route('admin.settings') }}">
                        <i class="material-icons">settings</i>
                        <span>Cài đặt</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i>
                        <span>Đăng Xuất</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endif
            @if (Request::is('author*'))
                <li class="{{ Request::is('author/dashboard') ? 'active' : "" }}">
                    <a href="{{ route('author.dashboard') }}">
                        <i class="material-icons">dashboard</i>
                        <span>Bảng điều khiển</span>
                    </a>
                </li>
                <li class="{{ Request::is('author/post*') ? 'active' : "" }}">
                    <a href="{{ route('author.post.index') }}">
                        <i class="material-icons">library_books</i>
                        <span>Bài viết</span>
                    </a>
                </li>
                <li class="{{ Request::is('author/favorite') ? 'active' : "" }}">
                    <a href="{{ route('author.favorite.index') }}">
                        <i class="material-icons">favorite</i>
                        <span>Bài viết yêu thích</span>
                    </a>
                </li>
                <li class="{{ Request::is('author/comments') ? 'active' : "" }}">
                    <a href="{{ route('author.comment.index') }}">
                        <i class="material-icons">comment</i>
                        <span>Bình luận</span>
                    </a>
                </li>
            <li class="header">System</li>
                <li class="{{ Request::is('author/setting') ? 'active' : "" }}">
                    <a href="{{ route('author.settings') }}">
                        <i class="material-icons">settings</i>
                        <span>Cài đặt</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i>
                        <span>Đăng Xuất</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endif
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2021 <a href="javascript:void(0);">Thiết kế bởi IRON FEVER</a>.
        </div>
        <div class="version">
            <b>Phiên bản: </b> 2.0
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->