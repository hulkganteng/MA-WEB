<?php

use App\Models\ActivityLog;
use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('activity_log')) {
    function activity_log(string $action, mixed $subject = null, array $properties = []): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => is_object($subject) ? get_class($subject) : null,
            'subject_id' => is_object($subject) ? $subject->getKey() : null,
            'properties' => $properties ?: null,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 500),
        ]);
    }
}

if (! function_exists('format_bytes')) {
    function format_bytes(int $bytes, int $precision = 1): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = $bytes > 0 ? floor(log($bytes, 1024)) : 0;

        return round($bytes / (1024 ** $pow), $precision).' '.$units[$pow];
    }
}

if (! function_exists('theme_color_scale')) {
    function theme_color_scale(string $hex, int $anchor = 600): array
    {
        if (! preg_match('/^#[0-9A-Fa-f]{6}$/', $hex)) {
            $hex = '#00923F';
        }

        $rgb = array_map('hexdec', str_split(substr($hex, 1), 2));
        $shades = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];
        $scale = [];

        foreach ($shades as $shade) {
            if ($shade === $anchor) {
                $mixed = $rgb;
            } elseif ($shade < $anchor) {
                $ratio = (($anchor - $shade) / ($anchor - 50)) * 0.94;
                $mixed = array_map(fn ($channel) => (int) round($channel + ((255 - $channel) * $ratio)), $rgb);
            } else {
                $ratio = (($shade - $anchor) / (950 - $anchor)) * 0.68;
                $mixed = array_map(fn ($channel) => (int) round($channel * (1 - $ratio)), $rgb);
            }

            $scale[$shade] = implode(' ', $mixed);
        }

        return $scale;
    }
}

if (! function_exists('theme_palette_css')) {
    function theme_palette_css(): string
    {
        $palettes = [
            'primary' => [setting('theme.primary', '#00923F'), 600, '#00923F'],
            'gold' => [setting('theme.accent', '#FFF500'), 400, '#FFF500'],
            'secondary' => [setting('theme.secondary', '#75C5F0'), 300, '#75C5F0'],
        ];
        $declarations = [];

        foreach ($palettes as $name => [$color, $anchor, $default]) {
            if (strtoupper((string) $color) === strtoupper($default)) {
                continue;
            }

            foreach (theme_color_scale((string) $color, $anchor) as $shade => $channels) {
                $declarations[] = "--color-{$name}-{$shade}: {$channels}";
            }
        }

        return implode(';', $declarations).';';
    }
}
