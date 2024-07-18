@extends('client.layouts.master')

@section('title')
    Home
@endsection

@section('content')
    <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Featured Products</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                        @foreach ($products as $product)
                            <div class="item">
                                <div class="block-4 text-center">
                                    <figure class="block-4-image">
                                        @php
                                            $url = $product->img_thumbnail;
                                            if (!Str::contains($url, 'http')) {
                                                $url = Storage::url($url);
                                            }
                                        @endphp
                                        <img src="{{ $url }}" alt="Image placeholder" class="img-fluid" />
                                    </figure>
                                    <div class="block-4-text p-4">
                                        <h3><a href="#">{{ Str::limit($product->name, 14) }}</a></h3>
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
                </div>
            </div>
        </div>
        <div class="site-section site-section-sm site-blocks-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-truck"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">Free Shipping</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Phasellus at iaculis quam.
                                Integer accumsan tincidunt fringilla.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-refresh2"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">Free Returns</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Phasellus at iaculis quam.
                                Integer accumsan tincidunt fringilla.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-help"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">Customer Support</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Phasellus at iaculis quam.
                                Integer accumsan tincidunt fringilla.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
