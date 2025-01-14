<!-- filepath: /d:/App/xampp/htdocs/first-project/ids-d3/resources/views/users/show.blade.php -->
@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>{{ $user->name }}</h1>
@stop

@section('content')
    <p>Email: {{ $user->email }}</p>
    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <a href="{{ route('user.index') }}" class="btn btn-secondary">Back to List</a>
@stop
