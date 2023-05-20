@extends('layouts.app')
@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Office boy listing') }}</div>
                <div class="card-body">
                    <div id="create-btn-on-listing" class="d-flex justify-content-end mt-3">
                        <a class="btn btn-primary btn-lg" href="{{ route('officeBoy.create') }}" role="button">Create Office Boy</a>
                    </div>
                    <div class="mx-3 my-3 table-responsive">
                        <table id="office-boy-table" class="table table-striped table-hover">
                            <caption>List of Office Boy</caption>
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
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
                                            <form id="deleteForm" action="{{ route('officeBoy.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button id="delete-office-boy-button" type="submit" class="btn btn-danger btn-lg">Delete</button>
                                            </form>
                                            <a class="btn btn-primary btn-lg" href="{{ route('officeBoy.edit', $user->id) }}" role="button">Edit</a>
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
</script>

@endsection
