@extends('layouts.app')

@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @role('Admin')
                        <div class="d-flex flex-row">
                            <div class="border-primary card d-flex justify-content-center align-items-center col-md-4 shadow p-3 rounded" style="width: 18rem;">
                                <a href="{{ route('products.index') }}" class="text-decoration-none">
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mt-3" style="width: 50px; height: 50px;">
                                      <i class="fa-solid fa-plus fa-2x"></i>
                                    </div>
                                    <div class="card-body">
                                      <h4>Products</h4>
                                    </div>
                                </a>
                            </div>

                            <div id="office-boy-card" class="border-primary card d-flex justify-content-center align-items-center col-md-4 shadow p-3 rounded" style="width: 18rem;">
                                <a href="{{ route('officeBoy.index') }}" class="text-decoration-none">
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mt-3" style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-person fa-2xl"></i>
                                    </div>
                                    <div class="card-body">
                                      <h4>Office Boy</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
