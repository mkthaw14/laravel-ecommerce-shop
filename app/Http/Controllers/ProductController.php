<?php

namespace App\Http\Controllers;

use App\Utilities\ImageUploadHandler;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    private $imageUploadHandler;

    public function __construct(ImageUploadHandler $imageUploadHandler)
    {
        $this->imageUploadHandler = $imageUploadHandler;
        //dd($imageUploadHandler);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $status = session("status");
        return view("backend.product", compact("products", "status", "categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "description" => "required",
            "price" => "required|numeric",
            "category_id" => "required",
            "image" =>  "required|mimes:png,jpg"
        ]);

        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator)->with("status", 2);
        }

        //dd($request->all());

        DB::transaction(function() use($request) {
            $product = new Product;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;

            $product->save();

            if($request->hasFile("image"))
            {

                try
                {
                    $product->image = $this->imageUploadHandler->saveImage($request->image, $product->id);
                    if($product->image == null)
                        throw new \Exception;

                    $product->save();
                }
                catch(\Exception $e)
                {
                    dd($e);
                }
            }
        });

        return redirect()->route("product.index")->with("status", 1);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "description" => "required",
            "price" => "required|numeric",
            "category_id" => "required",
            "image" =>  "mimes:png,jpg"
        ]);

        if($validator->fails())
        {
            
            return redirect()->back()->withInput()->withErrors($validator)->with('status', 3);
        }

        DB::transaction(function() use($request, $product) {
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;

            $product->save();

            //dd($request->all());
            if($request->hasFile("image"))
            {
                try
                {
                    $product->image = $this->imageUploadHandler->saveImage($request->image, $product->id);
                    if($product->image == null)
                        throw new \Exception;

                    $product->save();
                }
                catch(\Exception $e)
                {
                    dd($e);
                }
            }
        });

        return redirect()->route("product.index")->with("status", 1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::transaction(function() use($product) {
            if(count($product->orderItems) < 1)
            {
                $this->imageUploadHandler->deleteImage($product->id);
                $product->delete();
            }

        });

        return redirect()->route("product.index");
    }

    public function getProduct(Request $request)
    {
        $id = $request->id;

        $product = Product::find($id);
        return response()->json([
            "product" => $product
        ]);
    }
}
