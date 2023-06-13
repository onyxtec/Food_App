@extends('layouts.app')
@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Off Days Listing') }}</div>
                <div class="card-body">

                    <div id="create-btn-on-listing" class="d-flex justify-content-end mt-3">
                        <a class="btn btn-primary btn-lg" href="{{ route('off-days.create') }}" role="button">Add off day</a>
                    </div>

                    <div class="m-3 table-responsive">
                        <table id="off-days-table" class="table table-striped table-hover">
                            <caption>List of Off Days</caption>
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($off_days as $off_day)
                                    @php
                                        $start_date = Carbon\Carbon::createFromFormat('Y-m-d', $off_day->start_date)->format('D, j F Y');
                                        $end_date = Carbon\Carbon::createFromFormat('Y-m-d', $off_day->end_date)->format('D, j F Y');
                                    @endphp
                                    <tr>
                                        <td>{{ $off_day->id }}</td>
                                        <td>{{ $start_date }}</td>
                                        <td>{{ $end_date }}</td>
                                        <td>
                                            <div class="d-flex flex-row">
                                                <form id="deleteForm{{ $off_day->id }}" action="{{ route('off-days.destroy', $off_day->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button id="delete-office-boy-button" type="submit" onclick="deleteOffDay({{ $off_day->id }})" class="btn btn-danger btn-lg">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#off-days-table').DataTable({
        columnDefs: [
            {
                target: 0,
                visible: false,
                searchable: false,
            }
        ],
        order: [[0, 'desc']],
    });

    function deleteOffDay(Id) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + Id).submit();
            }
        });
    }
</script>

@endsection
