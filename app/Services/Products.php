<?php

namespace App\Services;

use App\DTO\Product\CreateDTO;
use App\DTO\Product\UpdateDTO;
use App\Models\Product;
use App\Repositories\ProductRepository;

class Products
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {
        
    }

    public function create(CreateDTO $dto): Product
    {
        $product = $this->productRepository->create($dto->toArray());

        $product->categories()->sync($dto->categoriesIds);

        return $product;
    }

    public function update(Product $product, UpdateDTO $dto): void
    {
        $this->productRepository->update($product->id, $dto->toArray());

        $product->categories()->sync($dto->categoriesIds);
    }

    public function delete(Product $product): void
    {
        $this->productRepository->delete($product->id);
    }
}