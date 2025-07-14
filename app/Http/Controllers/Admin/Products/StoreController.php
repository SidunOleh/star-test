<?php

namespace App\Http\Controllers\Admin\Products;

use App\DTO\Product\CreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Products;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct(
        public Products $products
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $product = $this->products->create(CreateDTO::createFromRequest($request));

        return response(new ProductResource($product));
    }
}
