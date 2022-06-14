<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

class PostCommentsController extends Controller
{
    public function __invoke($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(
                ['message' => 'Post not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        if (request()->filled('not_approved') && auth('sanctum')->check()) {
            $comments = $post->comments->where('status', Comment::NOT_APPROVED);
        } else {
            $comments = $post->comments->where('status', Comment::APPROVED);
        }

        return response()->json($comments);
    }
}
