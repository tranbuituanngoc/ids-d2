@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createUserModal">
        Create New User
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><span>{{ $user->name }}</span></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button class="btn btn-warning edit-user-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}">Edit</button>
                        <button class="btn btn-danger delete-user-btn" data-id="{{ $user->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
     @include('user.modal.create_modal')
     @include('user.modal.edit_modal')
     @include('user.modal.delete_modal')
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        var createUserUrl = '{{ route('user.store') }}';
        var updateUserUrl = '{{ route('user.update', ':id') }}';
        var deleteUserUrl = '{{ route('user.destroy', ':id') }}';
    </script>
    <script src="{{ asset('js/user.js') }}"></script>
@stop
