@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Product Listing') }}</div>
                <div id="create-btn-on-listing" class="d-flex justify-content-end mt-3">
                    <a class="btn btn-primary btn-lg" href="{{ route('product.create') }}" role="button">Create Products</a>
                </div>
                <div class="mx-3 my-3 table-responsive">
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
                                        <form id="deleteForm{{ $product->id }}" action="{{ route('product.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button id="delete-product-list-button" type="submit" onclick="deleteProduct({{ $product->id }})" class="btn btn-danger btn-lg">Delete</button>
                                        </form>
                                        <a class="btn btn-primary btn-lg" href="{{ route('product.edit', $product->id) }}" role="button">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    let table = new DataTable('#myTable');
    function deleteProduct(productId) {
        event.preventDefault(); //to suspend form submission
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + productId).submit();
            }
        });
    }
</script>


@endsection
