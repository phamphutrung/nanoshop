<?php

use App\Models\setting;

    function getConfigValue($config_key) {
        $setting = setting::where('config_key', $config_key)->first();
        if(! empty($setting)) {
            return $setting->config_value;
        }
        return null;
    }