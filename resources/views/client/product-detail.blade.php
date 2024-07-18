@extends('client.layouts.master')
@section('title')
    Chi tiết sản phẩm
@endsection

@section('content')
{{-- @dd(session('cart')) --}}
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ $product->img_thumbnail }}" alt="Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold text-dark">{{ $product->name }}</h3>
                <div class="d-flex justify-content-start mt-4 mb-3">
                    <p class="text-secondery font-weight-bold h3" style="text-decoration: line-through">
                        {{ number_format($product->price_regular, 0, ',', '.') }}VND
                    </p>
                    <p class="text-danger font-weight-bold h4 mx-2">
                        {{ number_format($product->price_sale, 0, ',', '.') }}VND
                    </p>
                </div>
                <p>{{$product->description}}</p>
                <form action="{{ route('cart.add') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                    @foreach ($sizes as $id => $name)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="radio_size_{{ $id }}"
                                name="product_size_id" value="{{ $id }}">
                            <label class="custom-control-label" for="radio_size_{{ $id }}">
                                {{ $name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                    @foreach ($colors as $id => $name)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="radio_color_{{ $id }}"
                                name="product_color_id" value="{{ $id }}">
                            <label class="custom-control-label" for="radio_color_{{ $id }}">
                                {{ $name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3 mt-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" min="1" required value="1"
                        placeholder="Enter quantity" name="quantity">
                </div>
                <button class="btn btn-primary" type="submit">Thêm vào giỏ hàng</button>
            </form>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô tả chi tiết</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Chất liệu</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Hướng dẫn sử dụng</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Mô tả chi tiết</h4>
                        <p>{{$product->content}}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Chất liệu</h4>
                        <p>{{$product->material}}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <h4 class="mb-3">Hướng dẫn sử dụng</h4>
                     <p>{{$product->user_manual}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
