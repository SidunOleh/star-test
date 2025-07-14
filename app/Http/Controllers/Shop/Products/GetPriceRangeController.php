<?php

namespace App\Http\Controllers\Shop\Products;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class GetPriceRangeController extends Controller
{
    public function __construct(
        public ProductRepository $productRepository
    )
    {
        
    }

    public function __invoke()
    {
        $range = $this->productRepository->getPriceRange();

        return response($range);
    }
}
