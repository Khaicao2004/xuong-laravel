@extends('client.layouts.master')

@section('title')
    Shop
@endsection

@section('content')
    @include('client.components.breadcrumb', ['pageName' => 'Shop'])

    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-9 order-2">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="float-md-left mb-4">
                                <h2 class="text-black h5">Shop All</h2>
                            </div>
                            <div class="d-flex">
                                <div class="dropdown mr-1 ml-md-auto">
                                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                        id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Latest
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                        <a class="dropdown-item" href="#">Men</a>
                                        <a class="dropdown-item" href="#">Women</a>
                                        <a class="dropdown-item" href="#">Children</a>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                        id="dropdownMenuReference" data-toggle="dropdown">
                                        Reference
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                        <a class="dropdown-item" href="#">Relevance</a>
                                        <a class="dropdown-item" href="#">Name, A to Z</a>
                                        <a class="dropdown-item" href="#">Name, Z to A</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Price, low to high</a>
                                        <a class="dropdown-item" href="#">Price, high to low</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        @foreach ($products as $product)
                        <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                            <div class="block-4 text-center border">
                                <figure class="block-4-image">
                                    <a href="{{ route('product.detail', $product->slug) }}">
                                        @php
                                        $url = $product->img_thumbnail;
                                        if (!Str::contains($url, 'http')) {
                                            $url = Storage::url($url);
                                        }
                                    @endphp
                                    <img src="{{ $url }}" alt="Image placeholder" width="100%" height="220" />
                                    </a>
                                </figure>
                                <div class="block-4-text p-4">
                                    <h3>
                                        <a href="{{ route('product.detail', $product->slug) }}">{{Str::limit($product->name, 14)}}</a>
                                    </h3>
                                    <div class="d-flex justify-content-around">
                                        <p class="text-secondery font-weight-bold"
                                            style="text-decoration: line-through">
                                            {{ number_format($product->price_regular, 0, ',', '.') }}VND
                                        </p>
                                        <p class="text-danger font-weight-bold">
                                            {{ number_format($product->price_sale, 0, ',', '.') }}VND
                                        </p>
                                    </div>
                                    <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-primary">Xem
                                        chi
                                        tiết</a>
                                </div>
                            </div>
                        </div>                       
                        @endforeach
                    </div>
                    <div class="row" data-aos="fade-up">
                        <div class="col-md-12 text-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-md-3 order-1 mb-5 mb-md-0">
                    <div class="border p-4 rounded mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">
                           <a href="{{ route('shop') }}" class="text-black"> Categories</a>
                        </h3>
                        <ul class="list-unstyled mb-0">
                            @foreach ($categories as $category)
                                <li class="mb-1">
                                    <a href="{{ route('shop',$category->id) }}" class="d-flex"><span>{{ $category->name }}</span>
                                        <span class="text-black ml-auto">{{ $category->products_count }}</span></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <form action="{{route('filter') }}" method="POST">
                        @csrf
                    <div class="border p-4 rounded mb-4">
                        {{-- <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">
                                Filter by Price
                            </h3>
                            <div id="slider-range" class="border-primary"></div>
                            <input type="text" name="text" id="amount"
                                class="form-control border-0 pl-0 bg-white" disabled="" />
                        </div> --}}

                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">
                                Size
                            </h3>
                            @foreach ($sizes as $size)                             
                            <label for="s_sm" class="d-flex">
                                <input type="checkbox" id="s_sm" class="mr-2 mt-1" name="size[]" value="{{$size->id}}"/>
                                <span class="text-black">{{$size->name}}</span>
                            </label>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">
                                Color
                            </h3>
                            @foreach ($colors as $color)
                            <div class="d-flex color-item align-items-center">
                                <input type="checkbox" id="s_sm" class="mr-2 mt-1" name="color[]" value="{{$color->id}}"/>
                                <span class=" color d-inline-block rounded-circle mr-2" style="background: {{$color->name}}"></span>
                                <span class="text-black">{{$color->name}}</span>
                            </div>                           
                            @endforeach
                        </div>
                        <div class="mt-3 mb-3">
                            <button class="btn btn-primary" type="submit">Fillter</button>
                        </div>
                    </div>
                    
                </form>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="site-section site-blocks-2">
                        <div class="row justify-content-center text-center mb-5">
                            <div class="col-md-7 site-section-heading pt-4">
                                <h2>Categories</h2>
                            </div>
                        </div>
                        <div class="row">
                         @foreach ($categories as $category)
                         <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                            <a class="block-2-item" href="{{ route('shop',$category->id) }}">
                                <figure class="image mt-3">
                                    <img src="{{ Storage::url($category->cover) }}" alt="" width="100%" height="150px" />
                                </figure>
                                <div class="text">
                                    <span class="text-uppercase">Fashion</span>
                                    <h3>{{$category->name}}</h3>
                                </div>
                            </a>
                        </div>
                         @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
