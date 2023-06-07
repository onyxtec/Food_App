<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function order(){

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

}
