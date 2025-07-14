<?php

namespace App\Http\Controllers\Shop\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class GetProductController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->load('categories');

        return response(new ProductResource($product));
    }
}
