<?php

namespace WpComponents\Router\Routes;

use WpComponents\Router\Utilities\PseudoRoute;

/**
 * Sitemap route
 */
class Sitemap extends PseudoRoute
{

    public function getTemplatePath(): string
    {
        return 'sitemap/sitemap';
    }

}
