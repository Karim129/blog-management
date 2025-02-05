@extends('layouts.dashboard')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row d-flex justify-content-between align-items-center mx-5">
                <div class="">
                    <h1 class="m-0"> Role</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Create</li>

                        <li class="breadcrumb-item active">Team</li>

                    </ol>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="container">

                <div class="row justify-content-around">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('roles.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                        <div class="invalid-feedback">Please enter the name.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="categories" class="mr-4">Permissions:</label>
                                        <div class="container">
                                            @foreach ($permissions->chunk(4) as $chunk)
                                                <div class="row mb-3">
                                                    @foreach ($chunk as $permission)
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $permission->name }}" name="permissions[]"
                                                                    id="permission-{{ $permission->id }}">
                                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>


            </div>
        </div>
    </section>
@endsection
