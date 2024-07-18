@extends('client.layouts.master')

@section('title')
    Cart
@endsection

@section('content')

@include('client.components.breadcrumb',['pageName' => 'Cart'])

<div class="site-section">
    <div class="container">
      <div class="row mb-5">
          <div class="site-blocks-table">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="product-thumbnail">Image</th>
                  <th class="product-name">Product</th>
                  <th class="product-price">Price Regular</th>
                  <th class="product-price">Price Sale</th>
                  <th class="product-price">Color</th>
                  <th class="product-price">Size</th>
                  <th class="product-quantity">Quantity</th>
                </tr>
              </thead>
              <tbody>
                @if (session()->has('cart'))
                        @foreach (session('cart') as $item)
                            <tr>
                              <td><img src="{{ $item['img_thumbnail'] }}" alt="" width="80px" height="80"></td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['price_regular'] }}</td>
                                <td>{{ $item['price_sale'] }}</td>
                                <td>{{ $item['color']['name'] }}</td>
                                <td>{{ $item['size']['name'] }}</td>
                                <td>
                                    {{ $item['quatity'] }}
                                </td>
                            </tr>
                        @endforeach

                    @endif
              </tbody>
            </table>
          </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="row mb-5">
            <div class="col-md-6">
                <a href="{{ route('index') }}" class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 pl-5">
          <div class="row justify-content-end">
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-12 text-right border-bottom mb-5">
                  <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                </div>
              </div>
              <div class="row mb-5">
                <div class="col-md-6">
                  <span class="text-black">Total</span>
                </div>
                <div class="col-md-6 text-right">
                  <strong class="text-black">{{ number_format($totalAmount) }} VND</strong>
                </div>
              </div>
              <form action="{{ route('order.save') }}" method="post">
                @csrf
                <div class="mt-3 mb-2">
                    <label for="user_name" class="form-label">{{ Str::convertCase('user_name', MB_CASE_TITLE) }}</label>
                    <input type="text" name="user_name" id="user_name" class="form-control" value="{{ auth()->user()?->name }}">
                </div>
                <div class="mt-3 mb-2">
                    <label for="user_email" class="form-label">{{ Str::convertCase('user_email', MB_CASE_TITLE) }}</label>
                    <input type="text" name="user_email" id="user_email" class="form-control" value="{{ auth()->user()?->name }}">
                </div>
                <div class="mt-3 mb-2">
                    <label for="user_phone" class="form-label">{{ Str::convertCase('user_phone', MB_CASE_TITLE) }}</label>
                    <input type="text" name="user_phone" id="user_phone" class="form-control">
                </div>
                <div class="mt-3 mb-2">
                    <label for="user_address" class="form-label">{{ Str::convertCase('user_address', MB_CASE_TITLE) }}</label>
                    <input type="text" name="user_address" id="user_address" class="form-control">
                </div>
                <div class="row mt-2">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg py-3 btn-block" type="submit">Thanh toán</button>
                  </div>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
