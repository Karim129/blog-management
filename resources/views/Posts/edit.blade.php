@extends('layouts.app2')

@section('content')
<div class="container">
    <h1>Edit Post</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title:</label>
            <input style="color:black" type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}"
                required>
        </div>

        <div class="form-group">
            <label for="slug">Slug:</label>
            <input style="color:black"type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $post->slug) }}"
                required>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea name="content" id="content" class="form-control" rows="5"
                required>{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" class="form-control-file">
            @if ($post->image)
            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="img-thumbnail mt-2"
                width="200">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update Post</button>
    </form>
</div>
@endsection
