@extends('layouts.app2')



@section('content')
    <div class="container">

        @can('create', App\Models\User::class)
            <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New User</a>
        @endcan

        @if ($users->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td>
                                @can('view', $user)
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-info">View</a>
                                @endcan

                                {{-- @can('update', $user)
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Edit</a>
                                @endcan --}}

                                @can('delete', $user)
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }}
        @else
            <p>No users found.</p>
        @endif
    </div>
@endsection
