<?php

namespace App\Services;

use App\DTO\Category\CreateDTO;
use App\DTO\Category\UpdateDTO;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class Categories 
{
    public function __construct(
        private CategoryRepository $categoryRepository
    )
    {
        
    }

    public function create(CreateDTO $dto): Category
    {
        return $this->categoryRepository->create($dto->toArray());
    }

    public function update(Category $category, UpdateDTO $dto): void
    {
        $this->categoryRepository->update($category->id, $dto->toArray());
    }

    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category->id);
    }
}