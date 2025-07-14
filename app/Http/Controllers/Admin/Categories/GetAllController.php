<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoriesAllCollection;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class GetAllController extends Controller
{
    public function __construct(
        public CategoryRepository $categoryRepository
    )
    {
        
    }

    public function __invoke()
    {
        $categories = $this->categoryRepository->getAll();

        return response(new CategoriesAllCollection($categories));
    }
}
