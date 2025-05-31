<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repository\Contracts\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);
        $categories = $categoryRepository->all();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);
        $category = $categoryRepository->create($request->validated());
        return response()->json([
            'message' => 'Category created successfully',
            'data' => new CategoryResource($category),
        ], Response::HTTP_CREATED); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);
        $category = $categoryRepository->find($category->id);
        return response()->json([
            'data' => new CategoryResource($category),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);
        $categoryUpdated = $categoryRepository->update($category, $request->validated());
        return response()->json([
            'message' => 'Category updated successfully',
            'data' => new CategoryResource($categoryUpdated),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);
        $deleted =  $categoryRepository->delete($category);

        if(!$deleted){
            return response()->json([
                'message' => 'Category not deleted',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Category deleted successfully',
        ], Response::HTTP_OK);
    }
}
