@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Office boy listing') }}</div>
                <div class="card-body">
                    <div id="create-btn-on-listing" class="d-flex justify-content-end mt-3">
                        <a class="btn btn-primary btn-lg" href="{{ route('officeBoy.create') }}" role="button">Create Office Boy</a>
                    </div>
                    {{-- <div class="mx-3 my-3 table-responsive">
                        <table id="myTable" class="table table-striped table-hover">
                            <caption>List of Product</caption>
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Images</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        @foreach ($product->images as $image)
                                            <img src="{{ asset('storage/products/'.$image->image) }}" alt="Product Image" width="50">
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row">
                                            <form id="deleteForm{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button id="delete-product-list-button" type="submit" onclick="deleteProduct({{ $product->id }})" class="btn btn-danger btn-lg">Delete</button>
                                            </form>
                                            <a class="btn btn-primary btn-lg" href="{{ route('products.edit', $product->id) }}" role="button">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
