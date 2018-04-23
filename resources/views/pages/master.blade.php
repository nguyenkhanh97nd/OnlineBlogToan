<!DOCTYPE html>
<html lang="vi">

<head>
  <base href="/">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title-header')</title> 
  <!-- X-CSRF-TOKEN -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Online Blog Toán, Thi thử online các môn Toán, Lý, Hoá, Sinh, Sử, Địa trên Blog Toán" />
  <meta name="keywords" content="thi thu online toan, thi thu online hoa, thi thu online sinh, thi thu online vat ly"/>
  <meta name="revisit-after" content="1 days" />
  <meta name="robots" content="INDEX,FOLLOW"/>
  <link rel="canonical" href="{{ url()->current() }}"/>
  <link rel="author" href="https://plus.google.com/102529050099795243520"/>
  <link rel="publisher" href="https://plus.google.com/102529050099795243520"/>
  <meta itemprop="name" content="Online Blog Toán, Thi thử online THPT Quốc Gia">
  <meta itemprop="description" content="Online Blog Toán, Thi thử online các môn Toán, Lý, Hoá, Sinh, Sử, Địa trên Blog Toán">
  <meta itemprop="image" content="{!! URL::asset('logo.jpg') !!}">
  <meta property="og:title" content="Online Blog Toán - Thi thử Online THPT Quốc Gia" />
  <meta property="og:locale" content="vi_VN" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url()->current() }}" />
  
  <meta property="og:description" content="Online Blog Toán, Thi thử online các môn Toán, Lý, Hoá, Sinh, Sử, Địa trên Blog Toán" />
  <meta property="og:site_name" content="Online Blog Toán" />
  <meta property="fb:admins" content="100006087014698" />
  

  
  @yield('image-page')
    <meta property="og:image" content="{!! URL::asset('logo.jpg') !!}" /><meta itemprop="image" content="Link đến hình đại diện cho bài viết">
  @yield('next-page')

  <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon">
  <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon">    
      
    
    {{-- <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    [if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif] --}}

  <link rel="stylesheet" href="/public/page/css/app.css">
  <script type="text/javascript" src="/public/page/js/jquery.min.js"></script>


</head>

<body >

  <div id="app_client" ></div>

  
  <script type="text/javascript" src="/public/page/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="/public/page/js/app.js"></script>

  @if(!Auth::check())
      <script type="text/javascript">
          localStorage.removeItem('token')
      </script>
  @endif

</body>


</html>
