<?php

namespace App\Repository\Contracts;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function find(int $id): Category;

    public function all(): \Illuminate\Support\Collection;

    public function create(array $data): Category;

    public function update(Category $category, array $data): Category;

    public function delete(Category $category): bool;
}
