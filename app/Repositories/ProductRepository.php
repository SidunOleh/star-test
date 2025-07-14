<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository
{
    protected string $model = Product::class;

    public function getPage(
        int $page = 1,
        int $perPage = 10,
        string $orderBy = 'created_at',
        string $order = 'DESC',
        array $filters = [],
        array $relationships = []
    ): LengthAwarePaginator
    {
        $q = $this->model::query();

        foreach ($filters as $field => $values) {
            if ($field == 'categories') {
                $q->whereHas('categories', fn (Builder $q) => $q->whereIn('categories.id', $values));
            } elseif ($field == 'price') {
                $q->whereBetween('price', $values);
            } else {
                $q->whereIn($field, $values);
            }
        }

        $q->orderBy($orderBy, $order);

        if ($relationships) {
            $q->with($relationships);
        }

        return $q->paginate($perPage, ['*'], 'page', $page);
    }

    public function getPriceRange(): array 
    {
        return [
            (float) Product::min('price'),
            (float) Product::max('price'),
        ];
    }
}