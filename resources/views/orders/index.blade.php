@extends('layouts.app')

@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Order History') }}</div>
                <div class="card-body">
                    @role('Employee')
                        <div class="shadow p-4 mx-3">
                            <div class="mb-5">
                                <form action="{{ route('orders.history') }}", method="GET">
                                    @method('GET')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="date" name="order_filter_date" id="order_filter_date" value="{{ old('order_filter_date', date('Y-m-d'))}}" class="form-control shadow" required>
                                        </div>
                                        @error('order_filter_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="col-md-3">
                                            <select class="form-select shadow" name="order_filter_status">
                                                <option value="" selected hidden>select all</option>
                                                @foreach (config('orderstatus.order_statuses') as $key => $status)
                                                    <option value="{{ $key }}">
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-outline-primary shadow p-2" data-toggle="tooltip" data-placement="top" title="Apply filter"><i class="fa-solid fa-filter"></i> Apply</button>
                                            <button type="button" class="btn btn-dark shadow p-2" data-toggle="tooltip" data-placement="top" title="Clear all fields" onclick="clearInputFields()"><i class="fa-solid fa-eraser"></i> Clear</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if ($orders)
                            <div class="mx-3 my-3 table-responsive shadow p-4">
                                <table id="orders-table" class="table table-striped table-hover shadow">
                                    <caption>List of Orders</caption>
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orders-table-body" class="table-group-divider">
                                        @if ($orders->count() > 0)
                                            @foreach ($orders as $order)
                                                <tr>
                                                    @php
                                                        $total = 0;
                                                        $date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('D, j F Y');
                                                        $statuses = config('orderstatus.order_statuses');
                                                        foreach ($order->products as $product) {
                                                            $total += $product->pivot->quantity * $product->pivot->price;
                                                        }
                                                    @endphp
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $date }}</td>
                                                    <td>{{ $total}}</td>
                                                    <td>{{ $statuses[$order->status] }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row">
                                                            <button type="button" class="btn btn-outline-primary show-details-btn" value="{{ $order->id }}">
                                                                <i class="fa fa-eye" aria-hidden="true"></i> View
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No orders available for the selected date</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="order-details-modal" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Order Details</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-sm table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>SubTotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="order-details-table-modal"></tbody>
                                            </table>
                                            <div id="modal-total-price-div">
                                                <h5><span id="total-price"></span></h5>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-center align-items-center" role="alert">
                                <p class="text-center">No order is available</p>
                            </div>
                        @endif
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){
            $(document).on('click', '.show-details-btn', function (){
                let order_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/orders/'+order_id,
                    success: function(response) {
                        $('#order-details-table-modal').empty();
                        let total_price = 0;
                        response.products.forEach(function(product) {
                            $('#order-details-table-modal').append('<tr><td>' + product.name + '</td><td>' + product.pivot.price +' Rs.' + '</td><td>' + product.pivot.quantity + '</td><td>' + product.pivot.quantity * product.pivot.price +' Rs.' + '</td></tr>');
                            let price = parseFloat(product.pivot.price);
                            total_price += price * product.pivot.quantity;
                        });
                        $('#total-price').text("Total: "+total_price.toFixed(2)+" Rs.");
                        $('#order-details-modal').modal('show');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });

        function clearInputFields() {
            document.getElementById('order_filter_date').value = '';
        }
</script>

@endsection
