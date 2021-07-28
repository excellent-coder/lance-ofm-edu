<?php

namespace App\Http\Controllers;

use App\Models\ProductCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ProductCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ProductCat::all();
        $supers = ProductCat::where('super_parent_id', null)
            ->where('parent_id', null)
            ->get();
        $parents = ProductCat::where('parent_id', null)->get();
        $cats = ProductCat::whereNotnULL('parent_id')->get();

        return view(
            'admin.pages.products.categories',
            compact('categories', 'supers', 'parents', 'cats')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function children(Request $request)
    {
        // return $request->all();
        if (empty($request->part) || empty($request->id)) {
            return  [];
        }
        $part = $request->part;
        $cat = ProductCat::find($request->id);
        // return $cat;
        switch ($part) {
            case 'super':
                $parents = $cat->parents;
                // $parents = ProductCat::whereNull('parent_id')->whereNull('super_parent_id')
                //     ->get();

                return $parents;
                break;
            case 'parent':
                $children = $cat->children;
                return $children;
                break;
            case 'product_cat':
                return $cat->products;
                break;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $cat = new ProductCat();

        $exist = ProductCat::where('name', $request->name)
            ->where('parent_id', $request->parent_id)
            ->where('super_parent_id', $request->super_parent_id)
            ->first();
        if ($exist) {
            return [
                'message' => 'You already have this category saved',
                'type' => 'error'
            ];
        }

        $cat->name = $request->name;
        $cat->slug = Str::limit(Str::slug($request->name), 190, '');

        if (!empty($request->parent_id)) {
            if (ProductCat::where('name', $request->name)->first()) {
                $cat->slug = $cat->slug . '-' . $request->parent_id;
            }
        }

        $cat->parent_id = $request->parent_id;
        $cat->super_parent_id = $request->super_parent_id;

        $cat->save();

        return [
            'item' => $cat,
            'type' => 'success',
            'status' => 200,
            'timeout' => 10000,
            'message' => 'category added successfully'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCat  $productCat
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCat $productCat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCat  $productCat
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCat $productCat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCat  $productCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCat $cat)
    {
        // return $request->all();

        $exist = ProductCat::where('name', $request->name)
            ->where('parent_id', $request->parent_id)
            ->where('super_parent_id', $request->super_parent_id)
            ->where('id', '!=', $cat->id)
            ->first();
        if ($exist) {
            return [
                'message' => 'You already have this category saved',
                'type' => 'error'
            ];
        }
        $cat->name = $request->name;
        $cat->parent_id = $request->parent_id;
        $cat->super_parent_id = $request->super_parent_id;

        $cat->save();

        return [
            'item' => $cat,
            'type' => 'success',
            'status' => 200,
            'timeout' => 10000,
            'message' => "$cat->name category updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCat  $productCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCat $productCat)
    {
        //
    }
}
