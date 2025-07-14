<?php

namespace App\Http\Controllers\Admin\Categories;

use App\DTO\Category\CreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Categories;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct(
        public Categories $categories
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $category = $this->categories->create(CreateDTO::createFromRequest($request));

        return response(new CategoryResource($category));
    }
}
