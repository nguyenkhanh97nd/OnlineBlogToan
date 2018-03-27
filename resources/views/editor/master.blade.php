<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="content-language" content="vi">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title-header')</title> 
  <!-- jQuery -->
  <script type="text/javascript" src=" {{ url('editor/js/jquery.min.js') }} "></script>
    <!-- X-CSRF-TOKEN -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Chuyên trang chia sẻ kinh nghiệm làm bài thi THPT Quốc Gia, các bài viết hướng dẫn giải chi tiết đề thi thử môn Toán, hướng dẫn ôn tập tốt kỳ thi THPT Quốc Gia hiệu quả nhất" />
  <meta name="keywords" content="giai chi tiet de thi thu, thi thpt quoc gia, de thi thu mon toan"/>
  <meta name="revisit-after" content="1 days" />
  <meta name="robots" content="INDEX,FOLLOW"/>
  <link rel="canonical" href="{{ url()->current() }}"/>
  <link rel="author"§ href="https://plus.google.com/102529050099795243520"/>
  <link rel="publisher" href="https://plus.google.com/102529050099795243520"/>
  <meta itemprop="name" content="Giải chi tiết đề thi thử môn Toán - Tin tức thi thử THPT Quốc Gia">
  <meta itemprop="description" content="Chuyên trang chia sẻ kinh nghiệm làm bài thi THPT Quốc Gia, các bài viết hướng dẫn giải chi tiết đề thi thử môn Toán, hướng dẫn ôn tập tốt kỳ thi THPT Quốc Gia hiệu quả nhất">
  <meta itemprop="image" content="{!! url('logo.jpg') !!}">
  <meta property="og:title" content="Giải chi tiết đề thi thử môn Toán - Tin tức thi thử THPT Quốc Gia" />
  <meta property="og:locale" content="vi_VN" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url()->current() }}" />
  
  <meta property="og:description" content="Chuyên trang chia sẻ kinh nghiệm làm bài thi THPT Quốc Gia, các bài viết hướng dẫn giải chi tiết đề thi thử môn Toán, hướng dẫn ôn tập tốt kỳ thi THPT Quốc Gia hiệu quả nhất" />
  <meta property="og:site_name" content="Minivui Học Vui" />
  <meta property="fb: s" content="100006087014698" />

  
  @yield('image-page')
    <meta property="og:image" content="{!! url('logo.jpg') !!}" /><meta itemprop="image" content="Link đến hình đại diện cho bài viết">
  @yield('next-page')

  <link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
  <link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
  
  <!-- Bootstrap Core CSS -->
  <link href="{{ url('editor/css/app.css') }}" rel="stylesheet">
<script type="text/javascript" src="{!! url('editor/ckeditor/ckeditor.js') !!}"></script>
</head>
<body>
  <div class="container-body">

    <div class="main-container">

      <div class="col-md-2 left-col">
        <div class="dashboard-title page-header">
          <a href="{!! route('editor.dashboard.index') !!}">BlogToan - Editor</a>
        </div>
        <div class="profile media">
          <div class="wrapper">
            <div class="media-left">
              <span>{!! substr(Auth::user()->username,0,1) !!}</span>
            </div>
            <div class="media-body">
              <p>{!! Auth::user()->username !!}</p>
              <p>{!! 'Editor' !!}</p>
            </div>
          </div> 
        </div>
        <div class="sidebar-menu">
          <div class="menu-section">
            <div class="wrapper">
              <h4>Menu</h4>
              <div class="menu-left">
                <ul class="sidebar-left">
                  <li><a><span class="glyphicon glyphicon-user" style="font-size: 10px;margin-right:5px"></span>  Posts<span class="caret"></span></a>
                    <ul class="submenu">
                      <li><a href="{!! route('editor.posts.getAdd') !!}">Add Post</a></li>
                      <li><a href="{!! route('editor.posts.getList') !!}">All Posts</a></li>
                    </ul>
                  </li>
                  <li><a><span class="glyphicon glyphicon-pencil" style="font-size: 10px;margin-right:5px"></span> Questions<span class="caret"></span></a>
                    <ul class="submenu">
                      <li><a href="{!! route('editor.questions.getAdd') !!}">Add Quesions</a></li>
                      <li><a href="{!! route('editor.questions.getList') !!}">All Quesions</a></li>
                    </ul>
                  </li>

                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10 right-col">
        <div class="row">
          <div class="top-nav fixed-top" >
            <nav class="navbar navbar-inverse ">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle-left" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span> 
                  </button>
                </div>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="/profile/{!! Auth::user()->username !!}" title="{!! Auth::user()->name !!}"><span class="glyphicon glyphicon-user"></span> {!! Auth::user()->username !!}</a></li>
                  <li><a href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                      <span class="glyphicon glyphicon-log-in"></span> Đăng xuất
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form></li>
                </ul>
              </div>
            </nav>
          </div> 
          <div class="main-content-admin">
            
            <div class="wrapper">
                <h2>@yield('title')</h2>
                @if(Session::has('flash_message'))
                    <div class="alert alert-{!! Session::get('flash_level') !!}">
                        {!! Session::get('flash_message') !!}
                    </div>
                @endif

              @yield('content')        

            </div>

          </div>

        </div>
      </div>
    </div>  

  </div>

  <!-- Nhúng script -->
  @yield('script')
  
  <!-- Bootstrap Core JavaScript -->
  <script type="text/javascript" src="{{ url('editor/js/bootstrap.min.js')}}"></script>
  

  <script type="text/javascript" src=" {{ url('editor/js/app.js') }} "></script>



</body>
</html>
