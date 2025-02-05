@extends('layouts.app2')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>By {{ $post->user->name }} on {{ $post->created_at->format('F j, Y') }}</p>

    @if ($post->image)
    <img src="{{ asset( $post->image) }}" alt="{{ $post->title }}" class="img-fluid">
    @endif

    <div class="mt-3">
        {!! nl2br(e($post->content)) !!}
    </div>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
</div>
@endsection
