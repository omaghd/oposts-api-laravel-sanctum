<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index()
    {
        $posts = auth('sanctum')->check()
            ? Post::latest()->paginate(9)
            : Post::where('status', 'public')
                ->latest()
                ->paginate(9);

        return response()->json($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated());
        return response()->json($post);
    }

    public function show($id)
    {
        $post = auth('sanctum')->check()
            ? Post::find($id)
            : Post::where('id', $id)
                ->where('status', 'public')
                ->first();

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($post);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        if ($request->get('slug') != $post->slug) {
            $request->validate(['slug' => 'unique:posts,slug']);
        }

        $post->update($request->validated());

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted!']);
    }

    public function getTrashed()
    {
        return response()->json(Post::onlyTrashed()->latest()->paginate(9));
    }

    public function permanentlyDelete($id)
    {
        $post = Post::onlyTrashed()->find($id);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $post->forceDelete();

        return response()->json(['message' => 'Post permanently deleted!']);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->find($id);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $post->restore();

        return response()->json(['message' => 'Post restored!']);
    }
}
