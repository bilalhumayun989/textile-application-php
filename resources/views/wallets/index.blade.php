@extends('layouts.app')

@section('title','Wallets')

@section('content')
<div class="container mt-5">
    <h2>Wallets</h2>



    <table class="table table-striped">
        <thead>
            <tr><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($wallets as $wallet)
                <tr>
                    <td>{{ $wallet->name }}</td>
                    <td>{{ $wallet->email }}</td>
                    <td>{{ $wallet->phone }}</td>
                    <td>
                        <a href="{{ route('wallets.show', $wallet->id) }}" class="btn btn-sm btn-info">View</a>
                        <form action="{{ route('wallets.destroy', $wallet->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No wallets yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection