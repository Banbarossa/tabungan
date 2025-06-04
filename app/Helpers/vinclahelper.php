<?php

use Vinkla\Hashids\Facades\Hashids;

if (!function_exists('vinclaEncode')) {
    function vinclaEncode($value)
    {
        return Hashids::encode($value);
    }
}

if (!function_exists('vinclaDecode')) {
    function vinclaDecode($value)
    {
        $decoded= Hashids::decode($value);
        return isset($decoded[0]) ? $decoded[0] : null;
    }
}
