@extends('layouts.app2')

@section('content')
    <div class="container">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Error Messages -->
        @if (session('error'))
            @foreach (explode('.', session('error')) as $error)
                <div class="alert alert-danger">{!! $error !!}</div>
            @endforeach
        @endif

        <!-- Page Title -->
        <div class="mb-4">
            <h1>Blog Posts</h1>
        </div>

        <!-- Import and Export Section -->
        <div class="card mb-4">
            <div class="card-body">
                {{-- @can('export', App\Models\Post::class) --}}
                {{-- @if(Auth::user()->hasRole('Admin')) --}}

                <a href="{{ route('posts.export') }}" class="btn btn-success btn-block mb-3">Export to Excel</a>
                {{-- @endif --}}
                {{-- @endcan --}}

                @can('import', App\Models\Post::class)
                    <form action="{{ route('posts.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="file" class="form-control" id="customFile">
                            <button type="submit" class="btn btn-primary btn-block mt-3">Import from Excel</button>
                        </div>
                    </form>
                @endcan
            </div>
        </div>

        <!-- Posts Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Author</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ Str::limit($post->content, 50) }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
