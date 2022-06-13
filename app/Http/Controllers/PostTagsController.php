<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

class PostTagsController extends Controller
{
    public function index($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($post->tags);
    }

    public function attach($postId, $tagId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $post->tags()->syncWithoutDetaching($tagId);

        return response()->json($post->tags);
    }

    public function detach($postId, $tagId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $post->tags()->detach($tagId);

        return response()->json($post->tags);
    }
}
