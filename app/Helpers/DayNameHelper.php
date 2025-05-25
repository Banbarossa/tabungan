<?php

if (!function_exists('today_name')) {
    function today_name() {
        $hari = strtolower(now()->locale('id')->isoFormat('dddd'));
        return $hari;
    }
}
