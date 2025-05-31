<?php

namespace App\Repository\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function find(int $id): Product;

    public function all(int $perPage = 15, int $page = 1): \Illuminate\Pagination\LengthAwarePaginator;

    public function create(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function delete(Product $product): bool;
}
