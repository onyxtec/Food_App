<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- sweetalert  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
    {{-- Dropzon.js --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    {{-- filepond --}}
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    {{-- FilePond image preview  --}}
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
    {{--jquery  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- jquery validation plugin --}}
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    {{-- Dropzon.js --}}
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    {{-- FilePond --}}
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    {{-- Filepond preview --}}
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    {{-- FilePond file size validation --}}
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    {{-- filePond file type validation --}}
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    @role('Employee')
                        <div class="dropdown dropend product-cart-dropdown-div">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span id="cart-btn-badge-pill" class="badge badge-pill badge-danger">{{ Cart::getContent()->count() }}</span>
                            </button>
                            <div class= "dropdown-menu product-cart-dropdown-menu-div mt-4">
                                <div class="row total-header-section">
                                    <div class="col-lg-12 col-sm-12 col-12 total-section text-right">
                                        <p>Total: <span class="text-info">{{ Cart::getSubTotal() }} Rs.</span></p>
                                    </div>
                                </div>
                                @if(Cart::isEmpty())
                                    <div class="row cart-empty-message">
                                        <div class="col-lg-12 col-sm-12 col-12 text-center mt-1 alert alert-danger alert-dismissible fade show" role="alert">
                                            <p>No products in the cart.</p>
                                        </div>
                                    </div>
                                @else
                                    @foreach(Cart::getContent() as $cart_item)
                                        <div class="row cart-detail">
                                            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                                <img src="{{ asset('storage/products') }}/{{ $cart_item->attributes->image }}" />
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                                <p>{{ $cart_item->name }}</p>
                                                <span class="price text-info">Rs. {{ $cart_item->price }}</span> <span class="count"> Quantity:{{ $cart_item->quantity }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row mt-4">
                                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                            <a href="{{ route('view.to.cart') }}" class="btn btn-primary btn-block">View Cart</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endrole
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a href="#" id="navbarDropdown" class="nav-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" ria-expanded="false" v-pre>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            @php
                                                $src = auth()->user()->image === null ? Vite::asset('resources/images/default_image.jpg') : auth()->user()->image;
                                            @endphp
                                            <img src="{{ $src }}"  class="rounded-circle" width="40" height="40">
                                        </div>
                                        <div>
                                            {{ auth()->user()->name }} <br>
                                            <span>{{ auth()->user()->roles()->pluck('name')->implode(', ') }}</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('profile.index') }}"
                                    >
                                        Profile
                                    </a>
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                    >
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>

                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>
</html>
