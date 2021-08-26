<?php

use App\Models\Setting;
use App\Models\SettingTag;
use Symfony\Component\VarDumper\Cloner\Data;

function web_setting($tag, $title, $default = false)
{
    $tag = SettingTag::where('slug', $tag)->first();
    if (!$tag) {
        return $default;
    }
    $value = Setting::where('title', $title)->where('tag_id', $tag->id)->first();
    if (!$value) {
        return $default;
    }
    return $value->value;
}

function bv($title, $upper = 1)
{
    $title = json_encode(boolval($title));
    if ($upper) {
        $title = strtoupper($title);
    }
    return $title;
}

function dt($dt)
{
    return date('Y-m-d\TH:i', strtotime($dt));
}
