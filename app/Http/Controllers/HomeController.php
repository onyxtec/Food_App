<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'employee_verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $date = Carbon::now();
        $products = Product::with('images')->latest()->get();

        if ($request->order_filter_date != null) {
            $request->validate([
                'order_filter_date' => 'required|date',
            ]);
            $date = $request->order_filter_date;
        }

        $orders_query = Order::orderBy('created_at', 'desc');

        if ($request->order_filter_status !== null && $request->order_filter_status != 0) {
            $orders_query->where('status', $request->order_filter_status-1);
        }

        $orders = $orders_query->whereDate('created_at', $date)->get();

        return view('home', compact('products', 'orders'));
    }
}
