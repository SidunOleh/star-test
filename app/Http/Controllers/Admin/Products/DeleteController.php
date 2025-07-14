<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Products;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __construct(
        public Products $products
    )
    {
        
    }

    public function __invoke(Product $product)
    {
        $this->products->delete($product);

        return response(['message' => 'OK']);
    }
}
