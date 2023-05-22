@extends('layouts.app')
@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Office Boy Listing') }}</div>
                <div class="card-body">
                    <div id="create-btn-on-listing" class="d-flex justify-content-end mt-3">
                        <a class="btn btn-primary btn-lg" href="{{ route('office-boys.create') }}" role="button">Create Office Boy</a>
                    </div>
                    <div class="m-3 table-responsive">
                        <table id="office-boy-table" class="table table-striped table-hover">
                            <caption>List of Office Boy</caption>
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="d-flex flex-row">
                                            <form id="deleteForm{{ $user->id }}" action="{{ route('office-boys.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button id="delete-office-boy-button" type="submit" onclick="deleteOffoceBoy({{ $user->id }})" class="btn btn-danger btn-lg">Delete</button>
                                            </form>
                                            <a class="btn btn-primary btn-lg" href="{{ route('office-boys.edit', $user->id) }}" role="button">Edit</a>
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
    $('#office-boy-table').DataTable({
        columnDefs: [
            {
                target: 0,
                visible: false,
                searchable: false,
            }
        ],
        order: [[0, 'desc']],
    });

    function deleteOffoceBoy(productId) {
        event.preventDefault(); //to suspend form submission
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
                document.getElementById('deleteForm' + productId).submit();
            }
        });
    }
</script>

@endsection
