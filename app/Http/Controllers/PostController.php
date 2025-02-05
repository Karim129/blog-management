<?php

namespace App\Http\Controllers;

use App\Exports\PostsExport;
use App\Imports\PostsImport;
use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->can('viewAny', Post::class)) {
            $posts = Post::query()->paginate(25);

            return view('Posts.index', ['posts' => $posts]);
        } else {
            $posts = Post::query()->where('user_id', auth()->user()->id)->paginate(25);

            return view('Posts.index', ['posts' => $posts]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('create', Post::class)) {
            return view('Posts.create');
        } else {
            return redirect()->back()->with('error', 'You do not have permission to view this page.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'slug' => 'required|unique:posts,slug',
        ]);
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => ImageService::upload($request->file('image'), 'posts'),
            'user_id' => auth()->user()->id,
            'slug' => $request->slug,

        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if (auth()->user()->can('view', $post)) {
            return view('Posts.show', ['post' => $post]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (auth()->user()->can('update', $post)) {
            return view('Posts.edit', ['post' => $post]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => ImageService::upload($request->file('image'), 'posts'),
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth()->user()->can('delete', $post)) {
            ImageService::delete($post->image);
            $post->delete();

            return redirect()->route('posts.index');
        }
    }

    public function export()
    {
        // dd($this->authorize('export', Post::class));

        if (! Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to export posts.');
        }

        return Excel::download(new PostsExport(Auth::user()), 'posts.xlsx');
    }

    public function import(Request $request)
    {
        $this->authorize('import', Post::class);

        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        try {
            Excel::import(new PostsImport, $request->file('file'));

            return redirect()->route('posts.index')->with('success', 'Posts imported successfully.');
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $reasons = [];
            foreach ($errors as $rowErrors) {
                foreach ($rowErrors as $error) {
                    $reasons[] = $error;
                }
            }

            return redirect()->back()->with('error', 'Error importing file:<br>'.implode('<br>', $reasons));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing file: '.$e->getMessage());
        }
    }
}