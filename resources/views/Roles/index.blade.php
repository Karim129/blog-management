@extends('layouts.dashboard')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row d-flex justify-content-between align-items-center mx-5">
                <div class="">
                    <h1 class="m-0"> Role</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Role</li>

                    </ol>
                </div><!-- /.col -->
                <div>
                    @can('role-create')
                        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                            <a href="{{ route('roles.create') }}" class="btn btn-primary">Create New Role</a>
                        </div>
                    @endcan
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="container">

                <div class="row justify-content-around"></div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @can('role-view')
                                                    <a href="{{ route('roles.show', $role) }}" class="btn btn-primary">View</a>
                                                @endcan
                                                @can('role-edit')
                                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('role-delete')
                                                    <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                @endcan
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
    </section>
@endsection
