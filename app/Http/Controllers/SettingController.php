<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\SettingTag;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings =  SettingTag::all();
        return view('admin.pages.settings.index', compact('settings'));
    }

    public function storetag(Request $request)
    {
        if (!$request->tag) {
            return [
                'message' => 'Please fill the setting tag',
                'errors' => []
            ];
        }
        if (SettingTag::where('tag', $request->tag)->first()) {
            return [
                'message' => 'This tag is already saved',
                'errors' => "$request->tag is alraedy saved"
            ];
        }
        $s = new SettingTag();
        $s->tag = Str::lower($request->tag);
        $s->slug = Str::slug($request->tag);
        $s->save();
        return [
            'message' => "$s->tag saved successfully",
            'desc' => 'Refresh to see changes',
            'status' => '200'
        ];
    }
    public function updatetag(Request $request, SettingTag $tag)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'tag' => "required|max:50|unique:setting_tags,tag,$tag->id",
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $tag->tag = $request->tag;
        $tag->save();
        return [
            'message' => 'Tag updated successfully',
            'status' => 200
        ];
    }
    public function destroytag(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);

        $total = SettingTag::whereIn('id', $ids)->delete();

        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('tags', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
    public function tag($slug)
    {
        $tag = SettingTag::where('slug', $slug)->firstOrFail();
        return view('admin.pages.settings.edit', compact('tag'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SettingTag $tag)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'title' => "required|max:80",
                'file' => 'nullable|mimetypes:image/*,video/*|max:10000'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        if (Setting::where('name', $request->title)
            ->where('tag_id', $tag->id)->first()
        ) {
            return [
                'message' => 'This tag is already saved',
                'errors' => 'Try another'
            ];
        }
        $value = $request->value;
        $type = 'text';

        if ($request->hasFile('file')) {

            $slug = Str::slug($request->title);
            $file = $request->file('file');

            if ($file->isValid()) {
                $type = explode('/', $file->getMimeType())[0];

                if ($request->title == 'favicon') {
                    $name = 'favicon.' . $file->getClientOriginalExtension();
                    $file->move(public_path(), $name);
                    $value = $name;
                } else {
                    $name = $slug . time()
                        . '.' . $file->getClientOriginalExtension();
                    $value = $file->storeAs("settings/$tag->slug", $name);
                }
            }
        }

        $s = new Setting();
        $s->title = Str::lower(preg_replace('/[^\w\d]+/', '_', $request->title));
        $s->value = $value;
        $s->type = $type;
        $s->name = $request->title;
        $s->tag_id = $tag->id;
        $s->save();

        return [
            'message' => "$s->name saved successfully",
            'status' => 200
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingTag $tag)
    {
        // return $request->all();
        // $messages =
        $done = 0;
        foreach ($request->all() as $k => $v) {

            $type = 'text';

            if ($request->hasFile($k)) {

                $slug = Str::slug($k);
                $file = $request->file($k);

                if ($file->isValid()) {
                    $type = explode('/', $file->getMimeType())[0];

                    $old_file = Setting::where('title', $k)
                        ->where('tag_id', $tag->id)->first();

                    if ($type != $old_file->type) {
                        continue;
                    }
                    // unlink old file


                    if ($old_file) {
                        $old_file = 'storage/' . $old_file->value;

                        if (file_exists(public_path($old_file))) {
                            unlink(public_path($old_file));
                        }
                    }

                    $name = $slug . '-' . time()
                        . '.' . $file->extension();
                    $v = $file->storeAs("settings/$tag->slug", $name);
                }
            }
            $x =   DB::update("update settings set value = ? where title = '$k'", [$v]);
            $done += $x;
        }

        return [
            "message" => "$done settings updated successfully",
            'status' => 200,
            'type' => 'default',
            'timeout' => 10000
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
