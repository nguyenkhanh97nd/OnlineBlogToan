<!--Header NAV-->
<header>
<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container">
<div class="row">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="/">Online Blog Toán</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        @if(isset($categories))
        @foreach($categories as $category)
          <li><a href="{{ $category->slug }}.html" title="{{ $category->name }}">{{ $category->name }}</a></li>
        @endforeach
        @endif
        <li><a href="social-learning" title="Cộng đồng học tập">Cộng đồng học tập</a></li>
        <li><a href="search" title="Tìm kiếm">Tìm kiếm</a></li>
      </ul>
        
      <ul class="nav navbar-nav navbar-right">
        @if(!Auth::check())
            <li><a href="{{ route('register') }}" title="Đăng ký"><span class="glyphicon glyphicon-user"></span> Đăng kí</a></li>
            <li><a href="{{ route('login') }}" title="Đăng nhập"><span class="glyphicon glyphicon-log-in"></span> Đăng nhập</a></li>
            <script type="text/javascript">
              localStorage.removeItem('token');
            </script>
        @else

            {{-- TODO: Online Message --}}
            {{-- <li><a href="message"><span class="glyphicon glyphicon-envelope"></span> Tin nhắn</a></li> --}}
            <li><a href="follow"><span class="glyphicon glyphicon-plus"></span> Follow</a></li>
            <li><a href="profile/{{ Auth::user()->username }}" title="{{ Auth::user()->username }}"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->username }}</a></li>
            <li>
              
              <a id="logout-click" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                           localStorage.removeItem('token');
                           document.getElementById('logout-form').submit();
                           ">
                  <span class="glyphicon glyphicon-log-in"></span> Đăng xuất
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>

            </li>
            <script type="text/javascript">
              if(!localStorage.getItem('token')) {
                document.getElementById('logout-form').submit();
              }
            </script>
        @endif
       
      </ul>
    </div>
  </div>
  </div>
  </div>
</nav>
</header>