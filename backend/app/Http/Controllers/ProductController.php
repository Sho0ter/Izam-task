<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repository\Contracts\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductIndexRequest $request)
    {
        $productRepository = app(ProductRepositoryInterface::class);
        $products = $productRepository->all($request->perPage ?? 10, $request->page ?? 1);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $productRepository = app(ProductRepositoryInterface::class);
        $product = $productRepository->create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ], Response::HTTP_CREATED); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $productRepository = app(ProductRepositoryInterface::class);
        $product = $productRepository->find($product->id);
        return response()->json([
            'data' => new ProductResource($product),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $productRepository = app(ProductRepositoryInterface::class);
        $productUpdated = $productRepository->update($product, $request->validated());
        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($productUpdated),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $productRepository = app(ProductRepositoryInterface::class);
        $deleted =  $productRepository->delete($product);

        if(!$deleted){
            return response()->json([
                'message' => 'Product not deleted',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Product deleted successfully',
        ], Response::HTTP_OK);
    }
}
