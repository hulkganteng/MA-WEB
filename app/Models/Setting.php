<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = true;

    protected $fillable = ['group', 'key', 'value', 'type'];

    public static function get(string $key, mixed $default = null): mixed
    {
        return cache()->rememberForever("setting.{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting ? self::castValue($setting) : $default;
        });
    }

    public static function getMany(string $group): array
    {
        return cache()->rememberForever("settings.{$group}", function () use ($group) {
            return static::where('group', $group)->get()
                ->mapWithKeys(fn (self $s) => [$s->key => self::castValue($s)])
                ->all();
        });
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'string'): void
    {
        static::updateOrCreate(['key' => $key], [
            'group' => $group,
            'value' => is_scalar($value) ? $value : json_encode($value),
            'type' => $type,
        ]);
        cache()->forget("setting.{$key}");
        cache()->forget("settings.{$group}");
    }

    public static function flushGroup(string $group): void
    {
        cache()->forget("settings.{$group}");
    }

    private static function castValue(self $setting): mixed
    {
        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }
}
