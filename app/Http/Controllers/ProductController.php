<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DeliveryMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCat;
use App\Models\ProductGallery;
use App\Models\Setting;
use App\Models\SettingTag;
use App\Models\WebSegment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $preloader = null;
    private $image = null;
    public function __construct()
    {
        $tag = SettingTag::where('slug', 'shop')->first()->id;

        $image = Setting::where('tag_id', $tag)
            ->where('title', 'default_image')->first();
        if ($image) {
            $this->image = $image->value;
        }

        $preloader = Setting::where('tag_id', $tag)
            ->where('title', 'item_preloader_gif')->first();

        if ($preloader) {
            $this->preloader = $preloader->value;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supers = ProductCat::where('super_parent_id', null)
            ->where('parent_id', null)
            ->get();
        $methods = DeliveryMethod::all();
        return view('admin.pages.products.create', compact('supers', 'methods'));
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

        $valid = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'product_cat_id' => 'required',
                'title' => 'required|max:400',
                'item' => 'required_if:digital,1'
            ],
            [
                'product_cat_id.required' => 'Please Choose the category for this Product',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $product = new Product();
        $product->title = $request->title;
        $slug = Str::slug($request->title);

        if (Product::where('slug', $slug)->first()) {
            $end =  Product::where('slug', 'like', "%$slug%")->get()->count();
            $slug = Str::limit($slug, 180, '') . "-$end";
        }
        // return $slug;
        $product->slug = $slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->featured = intval($request->featured);
        $product->product_cat_id = $request->product_cat_id;
        $product->active = $request->active;

        $product->high_price = $request->high_price;

        // saving photo;
        if ($request->hasFile('item')) {
            $file = $request->file('item');
            if ($file->isValid()) {

                $name = $slug . time()
                    . '.' . $file->extension();
                $product->item = $file->storeAs('products/items', $name);
            }
        }
        $product->save();

        return [
            'status' => 200,
            'parent_id' => $product->id,
            'to' => route('admin.products'),
            'type' => 'success'
        ];
    }

    public function gallery(Request $request)
    {
        if (!$request->parent_id) {
            return [
                'message' => 'Unable to upload this file',
                'type' => 'error',
            ];
        }

        $id = $request->parent_id;
        $product = Product::findOrFail($id);
        $slug = $product->slug;

        $g = new ProductGallery();
        $g->product_id = $request->parent_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $name = $file->getClientOriginalName();

                $path = $slug . time() . '.' . $file->extension();

                $g->image = $file->storeAs('products/gallery', $path);

                $g->save();
                return [
                    'status' => 200,
                    'type' => 'success',
                    'message' => "$name Uploaded successfully"
                ];
            }
        }

        return [
            'status' => 200,
            'type' => 'error',
            'message' => "1 Upload failed"
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        // $product = $product->load("images:id,product_id,image,featured,active");
        // $product = $product->load("img");
        // return $product;
        return view('frontend.shop.single', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $supers = ProductCat::where('super_parent_id', null)
            ->where('parent_id', null)
            ->get();
        $methods = DeliveryMethod::all();
        $superParent = $product->category->superParent;
        $parent = $product->category->parent;
        $items = collect([
            'super_cat' => $superParent,
            'parent_cat' => $parent,
            'product_cat' => $product->Category,
            'product_cat_id' => $product->product_cat_id,
            'isDigitalProduct' => boolval($product->digital),
            'super_parent_id' => $superParent->id,
            'parent_id' => $parent->id,
        ]);
        $mains = collect([
            'price' => $product->price,
            'highPrice' => $product->high_price,
            'perDiscount' => $product->discount
        ]);
        // return $mains;
        return view(
            'admin.pages.products.edit',
            compact('product', 'supers', 'methods', 'items', 'mains')
        );
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
        $item_required = "required_if:digital,1";

        if ($product->item) {
            $item_required = "nullable";
        }

        $valid = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'product_cat_id' => 'required',
                'title' => 'required|max:400',
                'item' => "$item_required"
            ],
            [
                'product_cat_id.required' => 'Please Choose the category for this Product',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $product->title = $request->title;
        $product->description = $request->description;

        $product->price = $request->price;
        $product->high_price = $request->high_price;

        $product->discount = $request->discount;

        $product->featured = intval($request->featured);
        $product->product_cat_id = $request->product_cat_id;

        $product->active = $request->active;

        $slug = Str::slug($request->title);
        // saving photo;
        if ($request->hasFile('item')) {
            $file = $request->file('item');
            if ($file->isValid()) {

                $name = $slug . time()
                    . '.' . $file->extension();
                $product->item = $file->storeAs('products/items', $name);
            }
        }
        $product->save();

        return [
            'status' => 200,
            'parent_id' => $product->id,
            'to' => route('admin.products'),
            'type' => 'success'
        ];
    }

    public function activate(Request $request, Product $product)
    {
        $product->active = intval(!$product->active);
        $product->save();
        if ($product->active) {
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
            'message' => "$product->title $mes successfully",
            'add_class' => $fa_ad,
            'remove_class' => $fa_re,
            'timeout' => 8000,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
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
        $images = ProductGallery::whereIn('product_id', $ids)->get();

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image"))) {
                \unlink(public_path("storage/$img->image"));
            }
        });
        $images_total = ProductGallery::whereIn('product_id', $ids)->delete();

        $total = Product::whereIn('id', $ids)->delete();

        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total "
                . Str::plural('product', $total)
                . " and $images_total "
                . Str::plural('image', $images_total)
                . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }

    public function shop()
    {
        // $categories = ProductCat::whereNull('super_parent_id');
        $products = Product::latest('id')->take('20')->get();
        // $msc = collect(['preloader' => $this->preloader, 'image' => $this->image]);
        $msc = json_decode(json_encode(['preloader' => $this->preloader]));
        // return $msc->image;
        $products->each(function ($p) {
            $p->image = $p->img ? $p->img->image : $this->image;
        });
        // return $products;
        return view('frontend.shop.index', compact('products', 'msc'));
    }
}
