@extends('layouts.app')

@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Employee Listing') }}</div>
                <div class="m-3 table-responsive">
                    <table id="employee-listing-table" class="table table-striped table-hover">
                        <caption>List of Employees</caption>
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $src = $user->image ? $user->image : Vite::asset('resources/images/default_image.jpg');
                                            @endphp
                                            <img id="user-listing-image" src="{{ $src }}" alt="User Image" class="rounded-circle" width="60" height="60">
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->balance. " Rs" }}</td>
                                    <td>
                                        <div class="d-flex flex-row">
                                            <button type="button" class="btn btn-primary edit-balance-btn" value="{{ $user->id }}">Edit Balance</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="edit-balance-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Balance</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="balance-form" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="add-balance">Add Balance</label>
                                        <input type="number" class="form-control" id="add-balance" name="add_balance" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label for="sub-balance">Deduct Balance</label>
                                        <input type="number" class="form-control" id="sub-balance" name="sub_balance" min="0">
                                    </div>
                                    <div id="balance-form-error" class="error-message"></div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="balance-form" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#employee-listing-table').DataTable({
            columnDefs: [
                {
                    target: 0,
                    visible: false,
                    searchable: false,
                }
            ],
            order: [[0, 'desc']],
        });

        $(document).ready(function(){
            $(document).on('click', '.edit-balance-btn', function (){
                event.preventDefault();
                let userId = $(this).val();
                $('#balance-form').attr("action", "employee/"+ userId +"/edit/balance");
                $('#edit-balance-modal').modal('show');
            });
        });

        $('#add-balance').keyup(function() {
            if ($(this).val() !== '') {
                $('#sub-balance').prop('disabled', true);
                $('#sub-balance').val('');
            } else {
                $('#sub-balance').prop('disabled', false);
            }
        });

        $('#sub-balance').keyup(function() {
            if ($(this).val() !== '') {
                $('#add-balance').prop('disabled', true);
                $('#add-balance').val('');
            } else {
                $('#add-balance').prop('disabled', false);
            }
        });

        $('#balance-form').submit(function(event) {
            let addBalance = $('#add-balance').val();
            let subBalance = $('#sub-balance').val();
            let error = false;

            if (addBalance === '' && subBalance === '') {
                $('#add-balance').addClass('is-invalid');
                $('#sub-balance').addClass('is-invalid');
                $('#balance-form-error').text('Please provide a value for either "Add Balance" or "Deduct Balance" field.').addClass('text-danger');
                error = true;
            } else {
                $('#add-balance').removeClass('is-invalid');
                $('#sub-balance').removeClass('is-invalid');
                $('#balance-form-error').text('');
            }

            if (error) {
                event.preventDefault();
            }
        });

        $('#add-balance, #sub-balance').keyup(function() {
            $(this).removeClass('is-invalid');
            $('#balance-form-error').text('');
        });

    </script>
@endsection
