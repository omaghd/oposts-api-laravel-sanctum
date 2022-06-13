<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function store(StoreCategoryRequest $request)
    {
        if ($request->filled('parent_id')) {
            if ($this->hasParent($request->get('parent_id'))) {
                return response()->json(
                    ['message' => 'The parent category has already a parent!'],
                    Response::HTTP_NOT_IMPLEMENTED
                );
            }
        }

        $category = Category::create($request->validated());
        return response()->json($category);
    }

    private function hasParent($categoryId)
    {
        return Category::find($categoryId)->parent;
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(
                ['message' => 'Category not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($category);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        if ($request->filled('parent_id')) {
            if ($this->hasParent($request->get('parent_id'))) {
                return response()->json(
                    ['message' => 'The parent category has already a parent!'],
                    Response::HTTP_NOT_IMPLEMENTED
                );
            }
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json(
                ['message' => 'Category not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        if ($request->get('slug') != $category->slug) {
            $request->validate(['slug' => 'unique:categories']);
        }

        $category->update($request->validated());

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(
                ['message' => 'Category not found!'],
                Response::HTTP_NOT_FOUND
            );
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted!']);
    }
}
