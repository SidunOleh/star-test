<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Categories;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __construct(
        public Categories $categories
    )
    {
        
    }

    public function __invoke(Category $category)
    {
        $this->categories->delete($category);

        return response(['message' => 'OK']);
    }
}
