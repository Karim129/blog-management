@extends('layouts.app2')

@section('content')
<div class="container">
    <h1>Create New Post</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" >
            <label for="title">Title:</label>
            <input style="color:black" type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug:</label>
            <input style="color:black" type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea style="color:black" name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" class="form-control-file" required>
        </div>

        <button type="submit" class="btn btn-success">Create Post</button>
    </form>
</div>
@endsection
