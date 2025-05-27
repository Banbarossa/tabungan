<?php

use App\Models\Settingwhatsapp;

if (!function_exists('renderTemplate')) {
    function renderTemplate(string $template, array $data): string
    {
        return preg_replace_callback('/{{\s*(\w+)\s*}}/', function ($matches) use ($data) {
            $key = $matches[1];
            return $data[$key] ?? '';
        }, $template);
    }
}

if (!function_exists('cekSendMessage')) {
    function cekSendMessage($operator)
    {
        $set = Settingwhatsapp::latest()->first();
        if (!$set) return false;

        return match ($operator) {
            '+' => $set->send_when_setor && !is_null($set->template_setor),
            '-' => $set->send_when_tarik && !is_null($set->template_tarik),
            default => false,
        };
    }
}



