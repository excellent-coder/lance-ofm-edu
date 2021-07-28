<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Http\Request;
use App\Models\ProductCat;
use App\Models\Product;


class ShopBreadcrumb extends Component
{
    public $paths;
    public $currentPath;
    public $pageTitle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($section, $id)
    {

        $paths = [];

        switch ($section) {
            case 'product':
                $product = Product::find($id);
                $this->pageTitle = $product->title;

                $cat = $product->category;
                if ($cat) {
                    $paths[$cat->name] = route('shop.cat.show', $cat->slug);
                    $parent = $cat->parent;
                    if ($parent) {
                        $paths[$parent->name] = route('shop.cat.show', $parent->slug);
                    }
                    $super = $parent->superParent;
                    if ($super) {
                        $paths[$super->name] = route('shop.cat.show', $super->slug);
                    }
                }
                break;
            case 'category':
                $cat = ProductCat::find($id);
                $this->pageTitle = $cat->name;

                if ($cat) {
                    $paths[$cat->name] = route('shop.cat.show', $cat->slug);
                    $parent = $cat->parent;
                    if ($parent) {
                        $paths[$parent->name] =  route('shop.cat.show', $parent->slug);
                    }
                    $super = $parent->superParent;
                    if ($super) {
                        $paths[$super->name] =  route('shop.cat.show', $super->slug);
                    }
                }
        }

        $this->paths = $paths;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.shop-breadcrumb');
    }
}
