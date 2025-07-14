<?php

namespace App\Http\Controllers\Admin\Categories;

use App\DTO\Category\UpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Models\Category;
use App\Services\Categories;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __construct(
        public Categories $categories
    )
    {
        
    }

    public function __invoke(Category $category, UpdateRequest $request)
    {
        $this->categories->update($category, UpdateDTO::createFromRequest($request));

        return response(['message' => 'OK']);
    }
}
