<header class="navigation fixed-top">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-white">
        <a class="navbar-brand order-1" href="index.html">
          <img class="img-fluid" width="100px" src="theme/client/images/logo.png"
            alt="Reader | Hugo Personal Blog Template">
        </a>
        <div class="collapse navbar-collapse text-center order-lg-2 order-3" id="navigation">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" href="{{route('index')}}">Trang chủ</i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="{{route('index')}}">Sản phẩm</i>
              </a>
            </li>
  
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Giới thiệu</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Liên hệ</a>
            </li>
          </ul>
        </div>
  
        <div class="order-2 order-lg-3 d-flex align-items-center">
          
          <!-- search -->
          <form class="search-bar">
            <input id="search-query" name="s" type="search" placeholder="Nhập từ khóa">
          </form>
          
          <button class="navbar-toggler border-0 order-1" type="button" data-toggle="collapse" data-target="#navigation">
            <i class="ti-menu"></i>
          </button>
          <a href="{{route('login')}}" class="mx-3 text-end text-dark">Login</a>
          <a href="" class="mx-3 text-end text-dark">Register</a>
          {{-- <form action="{{route('logout')}}" method="POST" class="d-flex">
            @csrf
            <button class="btn btn-danger " type="submit">Logout</button>
        </form> --}}
        </div>
      </nav>
    </div>
  </header>