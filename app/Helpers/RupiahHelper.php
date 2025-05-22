<?php

if (!function_exists('format_rupiah')) {
    function format_rupiah($angka, $prefix = 'Rp') {
        if (empty($angka) || !is_numeric($angka)) {
            return $prefix . ' 0';
        }

        return $prefix . ' ' . number_format($angka, 0, ',', '.');
    }
}
