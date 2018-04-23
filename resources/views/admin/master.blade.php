<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="content-language" content="vi">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title-header')</title> 
  <!-- jQuery -->
  <script type="text/javascript" src=" {{ url('public/admin/js/jquery.min.js') }} "></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
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
  <meta itemprop="image" content="/public/logo.jpg">
  <meta property="og:title" content="Giải chi tiết đề thi thử môn Toán - Tin tức thi thử THPT Quốc Gia" />
  <meta property="og:locale" content="vi_VN" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url()->current() }}" />
  
  <meta property="og:description" content="Chuyên trang chia sẻ kinh nghiệm làm bài thi THPT Quốc Gia, các bài viết hướng dẫn giải chi tiết đề thi thử môn Toán, hướng dẫn ôn tập tốt kỳ thi THPT Quốc Gia hiệu quả nhất" />
  <meta property="og:site_name" content="Minivui Học Vui" />
  <meta property="fb:admins" content="100006087014698" />

  
  @yield('image-page')
    <meta property="og:image" content="/public/logo.jpg" /><meta itemprop="image" content="Link đến hình đại diện cho bài viết">
  @yield('next-page')

  <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/public/favicon.ico" type="image/x-icon">
  
  <!-- Bootstrap Core CSS -->
  <link href="{{ url('public/admin/css/app.css') }}" rel="stylesheet">
<script type="text/javascript" src="{!! url('public/admin/ckeditor/ckeditor.js') !!}"></script>
</head>
<body>
  <div class="container-body">
    <!-- Vuejs --> 
    <div id="root"></div>
  </div>
  
  <!-- Bootstrap Core JavaScript -->
  <script type="text/javascript" src="{{ url('public/admin/js/bootstrap.min.js')}}"></script>
  
  
  <script type="text/javascript" src="{{ url('public/admin/js/moment.min.js') }}"></script>

  <script type="text/javascript" src=" {{ url('public/admin/js/app.js') }} "></script>



</body>
</html>
