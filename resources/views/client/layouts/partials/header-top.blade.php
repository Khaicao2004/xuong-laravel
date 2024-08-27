<div class="site-navbar-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                <form action="" class="site-block-top-search">
                    <span class="icon icon-search2"></span>
                    <input type="text" class="form-control border-0" placeholder="Search" />
                </form>
            </div>

            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                <div class="site-logo">
                    <a href="{{ route('index') }}" class="js-logo-clone">SkyShop</a>
                </div>
            </div>

            <div class="col-6 col-md-4 order-3 text-md-right">
                <div class="site-top-icons">
                    <ul class="list-unstyled d-flex justify-content-end align-items-center">
                        <li class="mr-3">
                            <a href="{{ route('cart.list') }}" class="site-cart d-flex align-items-center">
                                <span class="icon icon-shopping_cart me-1"></span>
                                <span class="count badge bg-primary">{{ count(session('cart', [])) }}</span>
                            </a>
                        </li>
                        <li class="d-inline-block d-md-none">
                            <a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a>
                        </li>
                        @if (!Auth::user())
                        <li class="ms-3">
                            <a href="{{ route('login') }}" class="d-flex align-items-center">
                                <span class="icon icon-person"></span>
                            </a>
                        </li>   
                        @else   
                        <li class="ms-3">
                            <form action="{{ route('logout') }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                                </button>
                            </form>
                        </li>   
                        @endif
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
