<?php

/**
 * Theme registry. Add a new theme by appending a slug => config entry below.
 *
 * Each theme is self-contained:
 *   resources/views/themes/{slug}/layouts/app.blade.php   (the layout)
 *   resources/views/themes/{slug}/pages/{home,projects-index,project-show,page}.blade.php
 *   public/themes/{slug}/...                              (css, js, fonts, images)
 *
 * The active theme is stored on the `settings` singleton (column `active_theme`)
 * and the public controllers resolve `view("themes.{$theme}.pages.home", ...)`.
 */
return [

    'default' => env('PORTFOLIO_DEFAULT_THEME', 'reeni'),

    'themes' => [

        'reeni' => [
            'name' => 'Reeni — Hot Pink',
            'description' => 'Dark dramatic dark UI with #ff014f signature pink. 3D-tilt cards, spotlight cursor, letter-by-letter title reveals, mouse parallax on the hero.',
            'primary' => '#ff014f',
            'preview_emoji' => '🌹',
            'tags' => ['Dark', 'Bold', '3D tilt', 'Letter reveal'],
        ],

        'mohamed' => [
            'name' => 'Mohamed — 3D Showcase',
            'description' => 'Orange-accented design with a looping 3D video background, sidebar navigation, GSAP scroll-triggered animations, and Odometer counters. Premium agency style.',
            'primary' => '#F3500F',
            'preview_emoji' => '🔥',
            'tags' => ['Video bg', 'Sidebar nav', 'GSAP', 'Bootstrap'],
        ],

    ],

];
