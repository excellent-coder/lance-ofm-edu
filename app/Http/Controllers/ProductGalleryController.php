<?php

namespace App\Http\Controllers;

use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function activate(Request $request, ProductGallery $img)
    {
        $img->active = intval(!$img->active);
        $img->save();
        if ($img->active) {
            $mes = 'Activated';
            $fa_ad = 'fa-check';
            $fa_re = 'fa-times';
        } else {
            $mes = 'Deactivated';
            $fa_ad = 'fa-times';
            $fa_re = 'fa-check';
        }
        return [
            'status' => 200,
            'message' => "Image $mes successfully",
            'add_class' => $fa_ad,
            'remove_class' => $fa_re,
            'timeout' => 4000,
        ];
    }

    public function feature(Request $request, ProductGallery $img)
    {
        $status = intval(!$img->featured);
        if ($status == 1) {
            DB::update("update product_galleries set featured = '0' WHERE product_id = '$img->product_id'");
            $img->featured = 1;
            $img->save();
            return [
                'status' => 200,
                'message' => "This image is now set to featured for this product",
                'add_class' => 'featured-photo',
                'img' => true,
                'timeout' => 4000,
                'toogle' => true
            ];
        } else {
            $img->featured = 0;
            $img->save();
            return [
                'status' => 200,
                'type' => 'info',
                'message' => 'This image is no longer Featured',
                'img' => true,
            ];
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function show(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductGallery $productGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);

        // unlink images
        $images = ProductGallery::whereIn('id', $ids)->get();
        // return $images;
        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")))
                \unlink(public_path("storage/$img->image"));
        });

        $total = ProductGallery::whereIn('id', $ids)->delete();

        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('image', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
