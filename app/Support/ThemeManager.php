<?php

namespace App\Support;

use App\Models\Setting;

class ThemeManager
{
    /** Returns the currently active theme slug, falling back to config default. */
    public static function active(): string
    {
        try {
            $slug = Setting::current()->active_theme ?? null;
        } catch (\Throwable $e) {
            $slug = null;
        }

        $registered = array_keys(config('themes.themes', []));

        return ($slug && in_array($slug, $registered, true))
            ? $slug
            : config('themes.default', 'reeni');
    }

    /** Returns the full theme config block. */
    public static function config(?string $slug = null): array
    {
        $slug ??= static::active();
        return config("themes.themes.{$slug}", config('themes.themes.reeni', []));
    }

    /** Resolves a view path inside the active theme. e.g. view('home') → 'themes.reeni.pages.home'. */
    public static function view(string $page): string
    {
        return 'themes.'.static::active().'.pages.'.$page;
    }

    /** All registered themes (for the admin picker). */
    public static function all(): array
    {
        return config('themes.themes', []);
    }
}
