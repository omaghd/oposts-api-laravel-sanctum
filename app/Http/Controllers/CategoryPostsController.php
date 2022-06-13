<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryPostsController extends Controller
{
    public function index($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(
                ['message' => 'Category not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($category->posts);
    }

    public function attach($categoryId, $postId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(
                ['message' => 'Category not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $category->posts()->syncWithoutDetaching($postId);

        return response()->json($category->posts);
    }

    public function detach($categoryId, $postId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(
                ['message' => 'Category not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $category->posts()->detach($postId);

        return response()->json($category->posts);
    }
}
