<?php

namespace WpComponents\Router\Routes;

use WpComponents\Router\Utilities\PseudoRoute;

/**
 * Taxonomy Term route
 */
class TaxTermArchive extends PseudoRoute
{

    public function getTemplatePath(): string
    {
        $wp_query = $GLOBALS['wp_query'];
        $tax = $wp_query->query_vars['taxonomy'];
        $term = $wp_query->query_vars['term'];
        $dir = str_replace('tax_', '', $tax);

        return "$dir/tax_term";
    }

}
