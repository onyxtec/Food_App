@extends('layouts.app')
@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-between">
        <div class="container col-md-8 bg-white border rounded p-5">
            <div class="m-3 table-responsive">
                <table id="cart-view-table" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($cart_items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img id="cart-listing-image" src="{{ asset('storage/products') }}/{{ $item->attributes->image }}" alt="User Image" class="rounded-circle" width="60" height="60">
                                        {{ $item->name }}
                                    </div>
                                </td>
                                <td>Rs. {{ $item->price }}</td>
                                <td>
                                    <form action="{{ route('product.cart.update', $item->id) }}" method="POST" id="updateForm{{ $item->id }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" class="form-control text-center w-50" min="1" pattern="[0-9]*" inputmode="numeric" placeholder="Quantity" required/>
                                        <span class="text-danger">
                                            @error('quantity')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </form>
                                </td>
                                <td>Rs. {{ $item->price*$item->quantity }}</td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <form id="deleteForm{{ $item->id }}" action="{{ route('product.cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button id="remove-cart-item-button" type="submit" onclick="removeCartItem({{ $item->id }})" class="btn btn-outline-danger btn-lg"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </form>
                                        <button type="button" class="btn btn-outline-primary btn-lg" onclick="updateCartItem({{ $item->id }})"><i class="fas fa-edit"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (!Cart::getContent()->isEmpty())
                <div class="mr-5">
                    <div colspan="6" style="text-align: right;" class="mb-3">
                        <h4><strong>Total {{ $total }} Rs</strong></h4>
                    </div>

                    <div colspan="6" style="text-align: right;">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg"> <i class="fa fa-arrow-left"></i> Continue</a>
                    </div>

                </div>
            @endif
        </div>
        <div class="container col-md-3 bg-white bg-opacity-10 border rounded p-3 h-100">
            <div class="d-flex justify-content-between">
                <h4>PRODUCTS</h4>
                <h4>SUBTOTAL</h4>
            </div>
            <hr>
            @foreach ($cart_items as $item)
                <div class="d-flex justify-content-between">
                    <h5>{{ $item->name." x " .$item->quantity}}</h5>
                    <h5>Rs. {{ $item->price*$item->quantity}}</h5>
                </div>
            @endforeach
            <hr>
            <div class="d-flex justify-content-between">
                <h5>TOTAL</h5>
                <h5>Rs. {{ $total }}</h5>
            </div>
            <hr>
            <div class="text-center">
                <a href="{{ route('product.cart.placeOrder') }}" class="btn btn-outline-primary w-50"><i class="a fa-money"></i>Place Order</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function updateCartItem(itemId) {
        $('#updateForm' + itemId).submit();
    }

    function removeCartItem(productId) {
        event.preventDefault(); //to suspend form submission
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + productId).submit();
            }
        });
    }
</script>
@endsection
