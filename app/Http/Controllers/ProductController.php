<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('remove_images')->only(['edit','create']);
    }

    public function index(){
        $products = Product::with('images')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\-.,()&amp;#\']{1,255}$/'],
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:5000',
        ]);

        $temporaryImages = TemporaryFile::all();

        if ($validator->fails()) {
            foreach($temporaryImages as $temporaryImage){
                Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        foreach($temporaryImages as $temporaryImage){
            Storage::copy('public/products/tmp/'.$temporaryImage->folder.'/'.$temporaryImage->file, 'public/products/'.$temporaryImage->folder.'/'.$temporaryImage->file);
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $temporaryImage->folder.'/'.$temporaryImage->file
            ]);
            Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
            $temporaryImage->delete();
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function create()
    {
        return view('products.form');
    }

    public function update(Request $request, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\-.,()&amp;#\']{1,255}$/'],
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:5000',
        ]);

        $temporaryImages = TemporaryFile::all();

        if ($validator->fails()) {
            foreach($temporaryImages as $temporaryImage){
                Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        $product = Product::find($product_id);

        if($product){
            foreach ($product->images as  $image) {
                $path_arr = explode('/', $image->image);
                $folder = $path_arr[0];
                if($folder && Storage::disk('local')->exists('public/products/'.$folder)){
                    Storage::disk('local')->deleteDirectory('public/products/'.$folder);
                }
                $image->delete();
            }

            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->save();

            foreach($temporaryImages as $temporaryImage){
                Storage::copy('public/products/tmp/'.$temporaryImage->folder.'/'.$temporaryImage->file, 'public/products/'.$temporaryImage->folder.'/'.$temporaryImage->file);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $temporaryImage->folder.'/'.$temporaryImage->file
                ]);

                Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
                $temporaryImage->delete();
            }

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        }

        return redirect()->route('products.index')->with('error', 'Product not found.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            foreach ($product->images as  $image) {
                $path_arr = explode('/', $image->image);
                $folder = $path_arr[0];
                if($folder && Storage::disk('local')->exists('public/products/'.$folder)){
                    Storage::disk('local')->deleteDirectory('public/products/'.$folder);
                }
            }
            $product->delete();
            return redirect()->back()->with('success', 'Product deleted successfully');
        }
        return redirect()->back()->with('error', 'Product not found.');
    }

    public function edit($id){
        $product = Product::find($id);
        if($product){
            return view('products.form', compact('product'));
        }
        return redirect()->back()->with('error', 'Product not found.');
    }

    public function tempUpload(Request $request){

        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'images.*.required' => 'The image field is required.',
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The image must be a JPEG, PNG, or JPG file.',
            'images.*.max' => 'The image may not be greater than 2MB.',
        ]);

        if ($validator->fails()) {
            foreach($validator->errors()->messages() as $image_errors){
                session()->flash('error', $image_errors[0]);
                return response()->json(['error' => true]);
            }
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $file_name = $image->getClientOriginalName();
                $folder = uniqid('product-', true);
                $image->storeAs('public/products/tmp/'.$folder, $file_name);
                TemporaryFile::create([
                    'folder' => $folder,
                    'file' => $file_name,
                ]);
            }
            return $folder;
        }
        return '';
    }

    public function tempDelete(){
        $temporaryImage = TemporaryFile::where('folder', request()->getContent())->first();
        if($temporaryImage){
            Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
            $temporaryImage->delete();
        }
    }

    public function productDetails($id){
        $product = Product::find($id);
        if ($product) {
            return view('products.product-details', compact('product'));
        }
        return redirect()->route('home')->with('error', 'Product details not found');
    }

    public function addToCart($id){

        $product = Product::find($id);

        // dd($product->images ,Arr::first($product->images));
        // dd($product->images, $product->images()->first(),Arr::first($product->images));
        // dd($product->images()->first()->image);

        if($product){
            $cart = session()->get('cart', []);
            if(isset($cart[$id])) {
                $cart[$id]['quantity']++;
            }  else {
                $cart[$id] = [
                    "name" => $product->name,
                    "image" => $product->images()->first()->image,
                    "price" => $product->price,
                    "quantity" => 1
                ];
            }
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product add to cart successfully!');
        }
        return redirect()->route('home')->with('error', 'Product not found');


    }
}
