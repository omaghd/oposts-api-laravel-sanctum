<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Symfony\Component\HttpFoundation\Response;

class TagPostsController extends Controller
{
    public function index($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(
                ['message' => 'Tag not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($tag->posts);
    }

    public function attach($tagId, $postId)
    {
        $tag = Tag::find($tagId);

        if (!$tag) {
            return response()->json(
                ['message' => 'Tag not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $tag->posts()->syncWithoutDetaching($postId);

        return response()->json($tag->posts);
    }

    public function detach($tagId, $postId)
    {
        $tag = Tag::find($tagId);

        if (!$tag) {
            return response()->json(
                ['message' => 'Tag not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $tag->posts()->detach($postId);

        return response()->json($tag->posts);
    }
}
