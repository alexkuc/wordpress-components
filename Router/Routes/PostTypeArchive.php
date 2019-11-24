<?php

namespace WpComponents\Router\Routes;

use WpComponents\Router\Utilities\PseudoRoute;

/**
 * Custom Post Type route
 */
class PostTypeArchive extends PseudoRoute
{
    public function getTemplatePath(): string
    {
        $wp_query = $GLOBALS['wp_query'];
        $cpt = $wp_query->query_vars['post_type'];
        $dir = str_replace('cpt_', '', $cpt);

        return "$dir/cpt_archive";
    }
}
