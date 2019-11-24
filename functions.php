<?php

namespace WpComponents;

require __DIR__ . '/vendor/autoload.php';

use WpComponents\WordPress\{
    Menus,
    ThemeSupport,
    ScriptsStyles,
    PostTypesTaxonomies,
};

// theme support (add_theme_support())
(new ThemeSupport())->addWpHook();

// hide admin menus (wp-admin)
(new Menus())->addWpHook();

// custom css and js
(new ScriptsStyles())->addWpHooks()->addWpFilters();

// custom post types and taxonomies
(new PostTypesTaxonomies())->loadDefinitions();
