<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $status = session("status");
        return view("backend.category", compact("categories", "status"));
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
        $validator =  Validator::make($request->all(), [
            "name" => "required|unique:categories"
        ]);

        //dd($request->all());

        if($validator->fails())
        {
            //dd("fail");
            return redirect()->back()->withErrors($validator)->withInput()->with("status", 2); // 2 is redirect with error. This value would be stored as a form field which would cause the Jquery to show the modal form
                                                                                               // The status value will be handled by the script inside backend_template.blade.php
        }

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->route("category.index")->with("status", 1); // 1 is redirect with okay  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator =  Validator::make($request->all(), [
            "name" => ["required", Rule::unique("categories")->ignore($category->id, "id")]
        ]);



        if($validator->fails())
        {
            //dd("fail");
            return redirect()->back()->withErrors($validator)->withInput()->with("status", 3); 
        }

        //dd($request->all());

        $category->name = $request->name;
        $category->save();

        return redirect()->route("category.index")->with("status", 1); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //dd($category->id);
        if(count($category->products) < 1)
            $category->delete();

        return redirect()->route("category.index");
    }

    public function getCategory(Request $request)
    {
        $category_id = $request->id;
        $category = Category::find($category_id);
        return response()->json([
            "category" => $category
        ]);
    }
}
