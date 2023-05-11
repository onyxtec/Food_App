@extends('layouts.app')

@section('content')
<div class="container">

    @include('success')

    <div id="show-message" class="alert alert-success alert-dismissible fade show" role="alert"></div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Update Profile') }}</div>
                <div class="card-body">

                    <div class="d-flex justify-content-center align-items-center mb-3">
                        @php
                            $src = auth()->user()->image ? auth()->user()->image : Vite::asset('resources/images/default_image.jpg');
                        @endphp
                        <img id="profile-avatar" src="{{ $src }}" class="img-fluid rounded-circle">
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                        <form id="profile-image-form" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" id="profile-image" class="d-none" accept="image/*">
                        </form>
                        <button class="btn btn-primary" id="update-profile-image-button" type="button" onclick="document.getElementById('profile-image').click()">Update</button>
                        <button class="btn btn-danger" id="remove-profile-image-button" type="button" onclick="removeImage()">Remove</button>
                    </div>
                    <h4 class="mt-4">General Information</h4>
                    <div class="row">
                        <form method="POST" action="{{ route('profile.name.update') }}">
                            @csrf
                            @method('POST')
                            <label for="name">Name</label>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"  value="{{ old('name', auth()->user()->name) }}" required>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <label for="email">Email</label>
                            <p>{{ auth()->user()->email }}</p>
                        </div>

                        <div class="col-sm-6">
                            <label for="balance">Balance</label>
                            <p>{{ auth()->user()->balance }} Rs</p>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <form method="POST" action="{{ route('profile.password.update') }}">
                            @csrf
                            <label for="password" class="h4">Edit Password</label>
                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-4 mb-2">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password" required minlength="8">
                                            <span class="input-group-text eye-icon"><i class="fa fa-eye"></i></span>
                                        </div>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required minlength="8">
                                            <span class="input-group-text eye-icon"><i class="fa fa-eye"></i></span>
                                        </div>
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required minlength="8">
                                            <span class="input-group-text eye-icon"><i class="fa fa-eye"></i></span>
                                        </div>
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            <button type="submit" class="btn btn-primary mt-3">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#profile-image').change(function() {
        var formData = new FormData($('#profile-image-form')[0]);
        $.ajax({
            url: '{{ route("profile.image.update") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response.success){
                    $('#profile-image-preview').attr('src', response.image);
                    localStorage.setItem('message', response.message); // Store success message in cookie or local storage
                    location.reload();
                }else{
                    $('#show-message').removeClass("alert alert-success").addClass("alert alert-danger");
                    localStorage.setItem('message', response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#show-message').removeClass("alert alert-success").addClass("alert alert-danger").html('An error occurred: ' + errorThrown).show();
            }
        });
    });

    function removeImage() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this image!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, cancel',
            iconColor: '#dc3545',
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: "{{ route('profile.image.remove') }}",
                    method: "GET",
                    success: function(response) {
                        localStorage.setItem('message', response.message); // Store success message in cookie or local storage
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // console.log(xhr.responseText);
                        $('#show-message').removeClass("alert alert-success").addClass("alert alert-danger").html('An error occurred: ' + xhr.responseText).show();
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        var message = localStorage.getItem('message'); // Retrieve success message from cookie or local storage
        if (message !== null) {
            $('#show-message').text(message).show();
            localStorage.removeItem('message');// Remove success message from cookie or local storage after it has been displayed
        }
    });

    $(document).ready(function() {
        $('.eye-icon').on('click', function(e) {
            e.stopPropagation();
            var input = $(this).prev('input');
            var type = input.attr('type');
            if (type === 'password') {
                input.attr('type', 'text');
                $(this).html('<i class="fa fa-eye-slash"></i>');
            } else {
                input.attr('type', 'password');
                $(this).html('<i class="fa fa-eye"></i>');
            }
        });
    });
</script>
@endsection
