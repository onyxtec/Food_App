<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        $cart_items = \Cart::getContent();
        $cart_total = \Cart::getTotal();
        return view('cart.view' ,compact('cart_items', 'cart_total'));
    }

    public function add(Request $request, $id){

        $product = Product::find($id);

        if($product){
            $cart_item = \Cart::get($product->id);

            if($cart_item){

                if($request->quantity){

                    $request->validate([
                        'quantity' => 'required|numeric|min:1',
                    ]);

                    \Cart::update($product->id,[
                        'quantity' => [
                            'relative' => false,
                            'value' => $request->quantity,
                        ],
                    ]);

                }else{

                    \Cart::update($product->id, [
                        'quantity' => 1,
                    ]);

                }

                return redirect()->back()->with('success', 'Product added to cart successfully!');

            }else{
                \Cart::add(array(
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $request->quantity ? $request->quantity : 1,
                    'attributes' => array(
                        'image' => $product->images()->first()->image,
                    )
                ));
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
        }
        return redirect()->route('home')->with('error', 'Product not found');
    }

    public function remove($id)
    {
        if(\Cart::get($id)){
            \Cart::remove($id);
            return redirect()->back()->with('success', 'Product removed successfully!');
        }
        return redirect()->back()->with('error', 'Product not found');

    }

    public function update(Request $request, $id){
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        if(\Cart::get($id)){

            \Cart::update($id,[
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity,
                ],
            ]);

            return redirect()->back()->with('success', 'Quantity updated successfully.');
        }

        return redirect()->back()->with('error', 'Product not found');
    }

    public function checkout(){
        $cart_items = \Cart::getContent();
        $total = \Cart::getTotal();
        if(!$cart_items->isEmpty()){

            return view('cart.checkout', compact('cart_items', 'total'));
        }
        return redirect()->back()->with('error', 'Your cart is empty');
    }
}
