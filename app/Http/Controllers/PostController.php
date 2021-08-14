<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCat;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.pages.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PostCat::all();
        $tags = Tag::all();
        return view('admin.pages.posts.create', compact('categories', 'tags'));
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
                'title' => 'required|max:300',
                'image' => 'nullable|file|image'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        $title = $request->title;
        $cat = null;
        if ($request->post_cat) {
            $cat = $request->post_cat;
        } else if ($request->parent_cat) {
            $cat = $request->parent_cat;
        }
        $slug = Str::slug($title);

        if (Post::where('slug', $slug)->first()) {
            $slug .= '-' . Post::where('slug', 'like', "%$slug%")->count();
        }

        $post = new Post();
        $post->post_cat_id = $cat;
        $post->title = $title;
        $post->slug = $slug;
        $post->description = $request->description;

        $post->excerpt = $request->excerpt;
        $post->featured = intval($request->featured);
        $post->published = intval($request->published);

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = $slug . "-" . time()
                    . '.' . $file->extension();
                $post->image = $file->storeAs('blog/images', $name);
            }
        }

        $post->save();

        foreach ($request->tags as $t) {
            if (empty(trim($t))) {
                return;
            }
            PostTag::create(['post_id' => $post->id, 'tag_id' => $t]);
        }

        return [
            'message' => "Blog post added successfully",
            'status' => 200,
            'type' => 'success',
            'to' => route('admin.posts')
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $posts = Post::latest()->take(20)->get();
        return view('frontend.blog.single', compact('post', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = PostCat::all();
        $tags = Tag::all();
        $tagids = [];
        foreach ($post->tags as $tid) {
            $tagids[] = $tid->id;
        }
        $items = [];
        $mainCat = $post->category;
        if ($post->category) {
            if ($post->category->parent) {
                $cat = $post->category->parent;
                $pcat = $post->category;
                $cats = $cat->children;

                $items = [
                    'parent_cat' => ['id' => $cat->id, 'name' => $cat->name],
                    'post_cat' => ['id' => $pcat->id, 'name' => $pcat->name],
                    'categories' => $cats
                ];
            } else {
                $items = [
                    'parent_cat' => ['id' => $mainCat->id, 'name' => $mainCat->name]
                ];
            }
        }
        $items = collect($items);
        $postTags = json_encode($tagids);
        // return compact('categories', 'post', 'items', 'postTags');
        return view('admin.pages.posts.edit', compact('categories', 'post', 'items', 'tags', 'postTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'title' => 'required|max:300',
                'image' => 'nullable|file|image'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        $title = $request->title;
        $cat = null;
        if ($request->post_cat) {
            $cat = $request->post_cat;
        } else if ($request->parent_cat) {
            $cat = $request->parent_cat;
        }
        $slug = Str::slug(Str::limit($title, 170, ''));

        $post->post_cat_id = $cat;
        $post->title = $title;
        $post->description = $request->description;

        $post->excerpt = $request->excerpt;
        $post->featured = intval($request->featured);
        $post->published = intval($request->published);

        if ($request->remove_image) {
            if (file_exists(public_path("storage/$post->image")) && $post->image) {
                unlink(public_path("storage/$post->image"));
            }
            $post->image = null;
        }

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                // unlink old image
                if (file_exists(public_path("storage/$post->image")) && $post->image) {
                    unlink(public_path("storage/$post->image"));
                }

                $name = $slug . "-" . time()
                    . '.' . $file->extension();
                $post->image = $file->storeAs('blog/images', $name);
            }
        }

        $post->save();

        PostTag::where('post_id', $post->id)->delete();
        // update tags
        foreach ($request->tags as $t) {
            if (empty(trim($t))) {
                return;
            }
            PostTag::create(['post_id' => $post->id, 'tag_id' => $t]);
        }
        return [
            'message' => "Blog post updated successfully",
            'status' => 200,
            'type' => 'success',
            'to' => route('admin.posts')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Post::whereIn('id', $ids)->get(['image']);

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")) && $img->image) {
                unlink(public_path("storage/$img->image"));
            }
        });

        $total =  Post::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('post', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
