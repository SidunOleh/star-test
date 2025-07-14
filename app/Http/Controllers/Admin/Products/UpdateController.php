<?php

namespace App\Http\Controllers\Admin\Products;

use App\DTO\Product\UpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Product;
use App\Services\Products;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __construct(
        public Products $products
    )
    {
        
    }

    public function __invoke(Product $product, UpdateRequest $request)
    {
        $this->products->update($product, UpdateDTO::createFromRequest($request));

        return response(['message' => 'OK']);
    }
}
