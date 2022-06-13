<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::all());
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->validated());
        return response()->json($tag);
    }

    public function show($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(
                ['message' => 'Tag not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($tag);
    }

    public function update(UpdateTagRequest $request, $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(
                ['message' => 'Tag not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        if ($request->get('slug') != $tag->slug) {
            $request->validate(['slug' => 'unique:tags']);
        }

        $tag->update($request->validated());

        return response()->json($tag);
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(
                ['message' => 'Tag not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $tag->delete();

        return response()->json(['message' => 'Tag deleted!']);
    }
}
