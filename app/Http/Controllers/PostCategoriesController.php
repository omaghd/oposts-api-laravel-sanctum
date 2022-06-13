<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

class PostCategoriesController extends Controller
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

        return response()->json($post->categories);
    }

    public function attach($postId, $categoryId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $post->categories()->syncWithoutDetaching($categoryId);

        return response()->json($post->categories);
    }

    public function detach($postId, $categoryId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $post->categories()->detach($categoryId);

        return response()->json($post->categories);
    }
}
