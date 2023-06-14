@extends('layouts.app')

@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @role('Admin')
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div id="product-card-div" class="card border-primary shadow p-3 mt-3 rounded">
                            <a href="{{ route('products.index') }}" class="text-decoration-none">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div id="product-card-icon-div" class=" shadow d-flex justify-content-center align-items-center rounded-circle bg-primary text-white mt-3">
                                        <i class="fa-solid fa-plus fa-2x"></i>
                                    </div>
                                    <div class="mt-3">
                                        <h4>Products</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div id="office-boy-card-div" class="card border-primary shadow p-3 mt-3 rounded">
                            <a href="{{ route('office-boys.index') }}" class="text-decoration-none">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div id="office-boy-icon-div" class="shadow rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mt-3">
                                        <i class="fa-solid fa-person fa-2xl"></i>
                                    </div>
                                    <div class="mt-3">
                                        <h4>Office Boy</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div id="add-off-day-card-div" class="card border-primary shadow p-3 mt-3 rounded">
                            <a href="{{ route('off-days.index') }}" class="text-decoration-none">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div id="add-off-day-icon-div" class="shadow rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mt-3">
                                        <i class="fa fa-calendar fa-2xl" aria-hidden="true"></i>
                                    </div>
                                    <div class="mt-3">
                                        <h4>Off Days</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div id="time-settings-card-div" class="border-primary card shadow p-3 mt-3 rounded">
                            <a href="{{ route('time-settings.index') }}" class="text-decoration-none">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div id="time-settings-icon-div" class="shadow rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mt-3">
                                        <i class="fa-solid fa-clock fa-2xl"></i>
                                    </div>
                                    <div class="mt-3">
                                        <h4>Times Settings</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div id="edit-balance-card-div" class="border-primary card shadow p-3 mt-3 rounded">
                            <a href="{{ route('employees.index') }}" class="text-decoration-none">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div id="edit-balance-icon-div" class="shadow rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mt-3">
                                        <i class="fas fa-users fa-2xl"></i>
                                    </div>
                                    <div class="mt-3">
                                        <h4>Employees</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endrole
            @role('Employee')
                @if ($products)
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card mb-3 shadow p-3 rounded">
                                    <a href="{{ route('products.show', $product->id) }}">
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
                                            <p class="card-text overflow-hidden text-truncate col-6 col-md-2 col-lg-5" id="product-desc-para">{{ $product->description }}</p>
                                            <a class="btn btn-primary" href="{{ route('cart.add', $product->id) }}" role="button">Add To Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-center align-items-center" role="alert">
                        <p class="text-center">No product is available</p>
                    </div>
                @endif
            @endrole
            @role('Office Boy')
                @if ($orders)
                    <div class="mx-3 my-3 table-responsive">
                        <table id="orders-table" class="table table-striped table-hover">
                            <caption>List of Orders</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="orders-table-body">
                                @foreach ($orders as $order)
                                    <tr>
                                        @php
                                            $total = 0;
                                            $date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('D, j F Y');
                                            foreach ($order->products as $product) {
                                                $total += $product->pivot->quantity * $product->pivot->price;
                                            }
                                        @endphp
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $date }}</td>
                                        <td>{{ $total}}</td>
                                        <td>
                                            <select class="form-select order-status" id="status-dropdown" data-order-id="{{ $order->id }}" data-previous-value="{{ $order->status }}" onchange="changeOrderStatus({{ $order->id }}, this.value)" style="width: 40%;">
                                                <option value="0" selected hidden>pending</option>
                                                @foreach (config('orderstatus.order_statuses') as $key => $status)
                                                    @if ($status !== 'pending')
                                                        <option value="{{ $key }}" {{ $order->status === $key ? 'selected hidden' : ''}}>
                                                            {{ $status }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row">
                                                <button type="button" class="btn btn-outline-primary show-details-btn" value="{{ $order->id }}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> View
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
@endsection

@section('scripts')
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('#orders-table').DataTable({
                columnDefs: [
                    {
                        target: 0,
                        visible: true,
                        searchable: true,
                    }
                ],
                order: [[0, 'desc']],
            });
        });

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

        function changeOrderStatus(order_id, order_status) {

            let selectElement = $('.order-status[data-order-id="' + order_id + '"]');
            let previousValue = selectElement.data('previous-value');
            let selectedOptionText = selectElement.find('option:selected').text();

            Swal.fire({
                title: 'Change Order Status',
                text: 'Are you sure you want to change the order status to ' + selectedOptionText + ' ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    selectElement.attr('disabled', 'disabled');
                    localStorage.setItem('orderStatusDisabled_' + order_id, true);

                    $.ajax({
                        type: "PUT",
                        url: '{{ route("orders.update") }}',
                        data:{
                            order_id: order_id,
                            order_status: order_status,
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            alert('Something went wrong. Please try again.');
                        }
                    });
                }else{
                    selectElement.val(previousValue);
                }
            });
        }

        $(document).ready(function () {
            $('.order-status').each(function () {
                var order_id = $(this).data('order-id');
                var isDisabled = localStorage.getItem('orderStatusDisabled_' + order_id);
                if (isDisabled) {
                    $(this).attr('disabled', 'disabled');
                }
            });
        });
    </script>
@endsection
