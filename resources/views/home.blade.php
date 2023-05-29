@extends('layouts.app')

@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @role('Admin')
                <div class="d-flex flex-row">
                    <div id="product-card-div" class="border-primary card d-flex justify-content-center align-items-center col-md-4 shadow p-3 rounded">
                        <a href="{{ route('products.index') }}" class="text-decoration-none">
                            <div id="product-card-icon-div" class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mt-3">
                            <i class="fa-solid fa-plus fa-2x"></i>
                            </div>
                            <div class="card-body">
                            <h4>Products</h4>
                            </div>
                        </a>
                    </div>
                    <div id="office-boy-card" class="border-primary card d-flex justify-content-center align-items-center col-md-4 shadow p-3 rounded">
                        <a href="{{ route('office-boys.index') }}" class="text-decoration-none">
                            <div id="office-boy-icon-div" class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mt-3">
                                <i class="fa-solid fa-person fa-2xl"></i>
                            </div>
                            <div class="card-body">
                            <h4>Office Boy</h4>
                            </div>
                        </a>
                    </div>
                </div>
            @endrole
            @role('Employee')
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4">
                            <div class="card mb-3 shadow p-3 rounded">
                                <a href="{{ route('product.productDetails', $product->id) }}">
                                    <div class="card-header">
                                        @if ($product->images !== null)
                                            <img src="{{ asset('storage/products/'.$product->images[0]->image) }}" class="card-img-top img-rounded emp-card" alt="Product Image">
                                        @endif
                                    </div>
                                </a>
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <h6 class="card-title">{{ $product->price." Rs" }}</h6>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <p class="card-text overflow-hidden text-truncate" style="max-height: em; max-width: 15em">{{ $product->description }}</p>
                                        <a class="btn btn-primary" href="{{ route('product.add.to.cart', $product->id) }}" role="button">Add To Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endrole
        </div>
    </div>
</div>
@endsection
