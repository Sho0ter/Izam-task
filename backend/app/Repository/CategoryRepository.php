<?php

namespace App\Repository;

use App\Models\Category;
use App\Repository\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function find(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function all(): \Illuminate\Support\Collection
    {
        return Category::all();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        $category->refresh();
        return $category;
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
