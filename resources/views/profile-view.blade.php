@extends('layouts.app')

@section('content')
<div class="container">

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Update Profile') }}</div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-center align-items-center mb-3">
                        @if (Auth::user()->image === null)
                            <img src="{{ Vite::asset('resources/images/default_image.jpg') }}"  class="img-fluid rounded-circle" style="width: 150px; height: 150px; border: 3px solid gray;">
                        @else
                            <img src="{{ Auth::user()->image }}" class="img-fluid rounded-circle" style="width: 150px; height: 150px; border: 3px solid gray;">
                        @endif
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                        <form id="profile-image-form" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" id="profile-image" class="d-none" accept="image/*">
                        </form>
                        <button class="btn btn-primary" id="update-profile-image-button" type="button" onclick="document.getElementById('profile-image').click()" style="margin-right: 0.5rem;">Update</button>
                        <button class="btn btn-danger" id="update-profile-image-button" type="button" onclick="hitRoute()">Remove</button>
                    </div>

                    @php
                        $user = Auth::user();
                    @endphp

                    <h4 class="mt-4">Gernal Information</h4>
                    <div class="row">
                        <form method="POST" action="{{ route('user.name.update', $user->id) }}">
                            @csrf
                            @method('POST')
                            <label for="name">Name</label>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"  value="{{ old('name', $user->name) }}" required>
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
                            <p>{{ $user->email }}</p>
                        </div>

                        <div class="col-sm-6">
                            <label for="balance">Balance</label>
                            <p>{{ $user->balance }} Rs</p>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <form method="POST" action="{{ route('update.password') }}">
                            @csrf
                            <label for="password" class="h4">Edit Password</label>
                            <div class="form-group">
                                 <div class="row">

                                    <div class="col-md-4 mr-1 mb-2">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Old Password" required minlength="8">
                                            <span class="input-group-text eye-icon"><i class="fa fa-eye"></i></span>
                                        </div>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                   </div>

                                     <div class="col-md-4 mr-1 mb-2">
                                         <div class="input-group">
                                             <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required minlength="8">
                                             <span class="input-group-text eye-icon"><i class="fa fa-eye"></i></span>
                                            </div>
                                         @error('new_password')
                                             <span class="text-danger">{{ $message }}</span>
                                         @enderror
                                     </div>
                                     <div class="col-md-4 mr-1 mb-2">
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
                $('#profile-image-preview').attr('src', response.image);
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    function hitRoute() {
        $.ajax({
            url: "{{ route('profile.image.remove') }}",
            method: "GET",
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

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
