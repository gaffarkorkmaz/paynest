<?php
/*
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
*/
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getFunction')) {
    function getFunction($key = null)
    {
        $configs = Cache::remember('site_configs', 3600, function () {
            return DB::table('configs')->pluck('value', 'name')->toArray();
        });

        if ($key) {
            return $configs[$key] ?? null;
        }

        return $configs;
    }
}

if (!function_exists('updateConfig')) {
    function updateConfig($key, $value)
    {
        try {
            DB::table('configs')->where('name', $key)->update(['value' => $value]);
            Cache::forget('site_configs');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
