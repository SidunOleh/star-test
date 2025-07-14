<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoriesCollection;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function __construct(
        public CategoryRepository $categoryRepository
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('order_by', 'created_at');
        $order = $request->query('order', 'DESC');

        $categories = $this->categoryRepository->getPage($page, $perPage, $orderBy, $order);

        return response(new CategoriesCollection($categories));
    }
}
