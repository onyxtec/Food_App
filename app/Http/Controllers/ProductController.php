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
    }

    public function index()
    {
        return view('products.create');
    }

    public function storeProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\-.,()&amp;#\']{1,255}$/'],
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $temporaryImages = TemporaryFile::all();

        if ($validator->fails()) {
            foreach($temporaryImages as $temporaryImage){
                Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = new Product;
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
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

        return redirect()->back()->with('success', 'Your product  created. successfully!.');
    }

    public function tempUpload(Request $request){

        $validator = Validator::make($request->all(), [
            'image.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'image.*.required' => 'The image field is required.',
            'image.*.image' => 'The file must be an image.',
            'image.*.mimes' => 'The image must be a JPEG, PNG, or JPG file.',
            'image.*.max' => 'The image may not be greater than 2MB.',
        ]);

        if ($validator->fails()) {
            foreach($validator->errors()->messages() as $image_errors){
                session()->flash('error', $image_errors[0]);
                return response()->json(['error' => true]);
            }
        }

        if ($request->hasFile('image')) {
            $images = $request->file('image');
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
        session()->flash('success', 'Image removed successfully.');
    }

    public function listProducts(){
        $products = Product::with('images')->get();
        return view('products.listing', compact('products'));
    }

    public function destroyProduct($id)
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
        return redirect()->back()->with('error', 'Product not deleted successfully. Try again later!');
    }

    public function editProduct($id){
        $product = Product::find($id);
        if($product){
            return view('products.create', compact('product'));
        }
        return redirect()->back()->with('error', 'Some thing went wrong. Try again later!');
    }

    public function updateProduct(Request $request, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\-.,()&amp;#\']{1,255}$/'],
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $temporaryImages = TemporaryFile::all();

        if ($validator->fails()) {
            foreach($temporaryImages as $temporaryImage){
                Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::find($product_id);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        foreach($temporaryImages as $temporaryImage){
            Storage::copy('public/products/tmp/'.$temporaryImage->folder.'/'.$temporaryImage->file, 'public/products/'.$temporaryImage->folder.'/'.$temporaryImage->file);
            $product->Images()->update([
                'image' => $temporaryImage->folder.'/'.$temporaryImage->file
            ]);
            Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
            $temporaryImage->delete();
        }
        return redirect()->route('product.listing')->with('success', 'Your product updated. successfully!.');
    }
}
