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

  <link rel="stylesheet" href="public/page/css/app.css">
  <script type="text/javascript" src="public/page/js/jquery.min.js"></script>

</head>

<body  ng-app="myApp" ng-cloak>

<!--Facebook Root-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=160947010982381";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


    @include('layout.header')

	<!--Nhung content tu pages-->
  <div style="padding-top: 90px;"></div>
    @yield('content')
	<!--End Nhung -->
	
    @include ('layout.footer')
	
	<!-- Nhung script -->
	@yield('script')


  <script type="text/javascript" src="public/page/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular-route.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular-sanitize.js"></script>
  <script type="text/javascript" src="public/page/js/app.js"></script>


<!-- Angular Material requires Angular.js Libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular-animate.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular-aria.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular-messages.min.js"></script>

  <!-- Angular Material Library -->
  <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>

  <!-- Angular Material style sheet -->
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
  
  
  <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-MML-AM_CHTML'></script>

</body>

</html>
