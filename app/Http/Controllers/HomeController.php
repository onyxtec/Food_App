<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::with('images')->latest()->get();
        if ($products->isEmpty()) {
            $error = 'No product is available';
            return view('home', compact('error'));
        }
        return view('home', compact('products'));

        // $products = Product::with('images')->get();
        // if ($products){
        //     return view('home', compact('products'));
        // }
        // return redirect()->back()->with('error', 'No product is available');

        // return view('home');
    }
}
