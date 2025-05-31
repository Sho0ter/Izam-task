<?php

namespace App\Repository;

use App\Models\Product;
use App\Repository\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
    public $cacheDuration = 60;
    public function find(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function all(int $perPage = 10, int $page = 1): \Illuminate\Pagination\LengthAwarePaginator
    {
        $cacheKey = "products.page.{$page}.perPage.{$perPage}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($perPage) {
            return Product::paginate($perPage);
        });
    }

    public function create(array $data): Product
    {
        Cache::forget('products.all');
        $product = Product::create($data);
        return $this->uploadImage($product, $data['image']);
    }

    public function update(Product $product, array $data): Product
    {
        Cache::forget('products.all');
        $product->update($data);
        $product->refresh();
        return $product;
    }

    public function delete(Product $product): bool
    {
        Cache::forget('products.all');
        return $product->delete();
    }

    public  function decrementQuantity(Product $product, $quantity): Product
    {
       $product->decrement('quantity', $quantity);
       return $product;
    }

    public function incrementQuantity(Product $product, $quantity): Product
    {
       $product->increment('quantity', $quantity);
       return $product;
    }

    public function uploadImage(Product $product, $image): Product
    {
        $filename = time().'_'.$image->getClientOriginalName();
        $path = $image->storeAs('products', $filename, 'public');
       
        $product->image = $path;
        $product->save();
        return $product;
    }
}
