<?php

namespace WpComponents\Settings;

/**
 * Register theme-related features
 */
class ThemeSupport
{

    public function addWpHook(): void
    {
        \add_action('init', [$this,'addThemeSupport']);
    }

    public function addThemeSupport(): void
    {
        add_theme_support('post-thumbnails');
        add_image_size('thumbnail_small', 64, 64, true);
    }

}
