<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductsCollection;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function __construct(
        public ProductRepository $productRepository
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('order_by', 'created_at');
        $order = $request->query('order', 'DESC');

        $products = $this->productRepository->getPage($page, $perPage, $orderBy, $order, relationships: ['categories']);

        return response(new ProductsCollection($products));
    }
}
