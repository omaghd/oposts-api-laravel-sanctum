<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function index()
    {
        if (request()->filled('not_approved') && request()->bearerToken()) {
            $comments = Comment::where('status', Comment::NOT_APPROVED);
        } else {
            $comments = Comment::where('status', Comment::APPROVED);
        }
        return response()->json(
            $comments
                ->latest()
                ->paginate(10)
        );
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return response()->json($comment);
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(
                ['message' => 'Comment not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(
                ['message' => 'Comment not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted!']);
    }

    public function approve($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(
                ['message' => 'Comment not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $comment->status = true;
        $comment->save();

        return response()->json(['message' => 'Comment approved!']);
    }

    public function disapprove($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(
                ['message' => 'Comment not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $comment->status = false;
        $comment->save();

        return response()->json(['message' => 'Comment disapproved!']);
    }
}
