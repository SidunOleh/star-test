<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrdersCollection;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function __construct(
        public OrderRepository $orderRepository
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('order_by', 'created_at');
        $order = $request->query('order', 'DESC');

        $orders = $this->orderRepository->getPage($page, $perPage, $orderBy, $order, relationships: [
            'client', 
            'orderItems',
        ]);

        return response(new OrdersCollection($orders));
    }
}
