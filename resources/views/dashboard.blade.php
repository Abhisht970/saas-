@extends('layouts.app')

@section('content')
    <h3>{{ app('currentTenant')->name }} Dashboard</h3>
    <p>Welcome, {{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
    <p>Database: {{ DB::connection('tenant')->getDatabaseName() }}</p>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
    @endsection