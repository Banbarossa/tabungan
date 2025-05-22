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
        return Hashids::decode($value)[0];
    }
}
