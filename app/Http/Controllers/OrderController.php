<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Config;

class OrderController extends Controller
{
    public function store(){
        $user_balance = auth()->user()->balance;
        $total_cost = \Cart::getTotal();

        if($user_balance >= $total_cost){
            $order = new Order();
            $order->status = 0;
            $order->user_id = auth()->user()->id;
            $order->save();
            $cartItems = \Cart::getContent();

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem->id);
                $order->products()->attach($product->id, [
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                ]);
            }

            auth()->user()->balance -= $total_cost;
            auth()->user()->save();
            OrderCreated::dispatch($order);
            \Cart::clear();

            return redirect()->route('home')->with('success', 'Your order has been created successfully');
        }

        return redirect()->route('home')->with('error', 'Insufficient balance.');
    }

    public function update(Request $request){
        $order = Order::find($request->order_id);

        if($order){
            $order->status = $request->order_status;
            $order->save();
            $statuses = Config::get('orderstatus.order_statuses');

            if($statuses[$request->order_status] === 'canceled'){
                $order->user->balance += $this->getTotal($order);
                $order->user->save();
            }

            return $request->session()->flash('success', 'Order status updated successfully');
        }

        return $request->session()->flash('error', 'Order does not exist');
    }

    public function show($order_id){
        $order = Order::with('products', 'user')->find($order_id);
        return response()->json($order);
    }

    private function getTotal($order){
        $total = 0;

        foreach($order->products as $product){
            $total += $product->pivot->quantity * $product->pivot->price;
        }

        return $total;
    }

}
