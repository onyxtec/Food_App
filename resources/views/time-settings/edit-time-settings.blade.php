@extends('layouts.app')
@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Time Settings') }}</div>
                <div class="card-body">

                    <form  action="{{ route('time-settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="text" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', $order_start_time) }}" placeholder="Enter Order Start Time" required>
                            <span class="text-danger">
                                @error('start_time')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mb-3">
                          <label for="end_time" class="form-label">End Time</label>
                          <input class="form-control" type="text" id="end_time" name="end_time" value="{{ old('end_time', $order_end_time) }}" placeholder="Enter Order End Time" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
