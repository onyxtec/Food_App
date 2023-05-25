@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-12"> --}}

            {{-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div> --}}

            <div class="container">
                <div class="col-lg-12 border p-3 bg-white main-section">
                    <div class="row m-0 pl-3 pt-0 pb-3 product-detail-div-hedding">
                        Product Details
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 p-3 shadow left-side-product-box">
                            <div id="carouselExampleIndicators" class="carousel slide shadow" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach ($product->images as $index => $image)
                                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
                                        @if ($index == 0) class="active" aria-current="true" @endif aria-label="Slide {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    @foreach ($product->images as $index => $image)
                                      <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/products/'.$image->image) }}" class="d-block w-100 rounded" alt="Image {{ $index + 1 }}">
                                      </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="p-3 m-0 right-side-pro-detail border">
                                <div class="row">
                                    <div class="col-lg-12 mb-4">
                                        <h3 class="m-0 p-0">{{ $product->name }}</h3>
                                    </div>
                                    <div class="col-lg-12">
                                        <p class="m-0 p-0 price-pro"><strong>{{ $product->price." Rs" }}</strong></p>
                                        <hr class="p-0 mt-3">
                                    </div>
                                    <div class="col-lg-12 pt-2">
                                        <h5>Description</h5>
                                        <span>{{ $product->description  }}</span>
                                        <hr class="m-0 pt-2 mt-3">
                                    </div>
                                    <div class="col-lg-12 pt-2">
                                        <form action="" method="">
                                            <div class="form-group">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" name="quantity" class="form-control text-center w-50" id="quantity" placeholder="Enter quantity" value="1" min="1" required >
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <div class="col-lg-6 pb-2">
                                            <a href="#" class="btn btn-primary w-100">Add To Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection
