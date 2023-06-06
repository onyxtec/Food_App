@extends('layouts.app')
@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Off Days') }}</div>
                <div class="card-body">

                    <form  action="{{ route('off-days.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label for="start_date" class="form-label" id="date_label" >Choose Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" placeholder="Enter Start Date" required>
                            <span class="text-danger">
                                @error('start_date')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group mb-3" id="end_date_field" style="display: none;">
                          <label for="end_date" class="form-label">End Date</label>
                          <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" placeholder="Enter End Date">
                          <span class="text-danger">
                                @error('end_date')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input largerCheckbox" name="pick_range" type="checkbox" value="" id="pick_range_checkbox">
                            <label class="form-check-label largerCheckbox">Pick Range</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">Add off day</button>
                            <input class="form-check-input largerCheckbox" type="checkbox" value="" id="pick_range_checkbox">
                            <label class="form-check-label largerCheckbox">Pick Range</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">Add Off Day</button>
                            <input class="form-check-input largerCheckbox" name="pick_range" type="checkbox" value="" id="pick_range_checkbox">
                            <label class="form-check-label largerCheckbox">Pick Range</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">Add off day</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        let end_date_field = $('#end_date_field');
        let end_date_input = $('#end_date');

        $(document).ready(function() {
            $('#pick_range_checkbox').change(function() {
                if ($(this).is(':checked')) {
                    end_date_field.show();
                    end_date_input.prop('disabled', false);
                    $('#date_label').text('Start Date');
                    end_date_input.prop('required', true);
                    $('#pick_range_checkbox').val('true');
                } else {
                    end_date_field.hide();
                    end_date_input.prop('disabled', true);
                    $('#date_label').text('Choose Date');
                    end_date_input.prop('required', false);
                    $('pick_range_checkbox').prop('value', false);
                    $('#pick_range_checkbox').val('false');
                    $('pick_range_checkbox').prop('value', false);
                    $('#pick_range_checkbox').val('false');
                }
            });
        });
    </script>
@endsection
