<?php

use App\Models\Setting;
use App\Models\SettingTag;

function web_setting($tag, $title)
{
    $tag = SettingTag::where('slug', $tag)->first();
    if (!$tag) {
        return false;
    }
    $value = Setting::where('title', $title)->where('tag_id', $tag->id)->first();
    if (!$value) {
        return false;
    }
    return $value->value;
}

function bv($title)
{
    return json_encode(boolval($title));
}
