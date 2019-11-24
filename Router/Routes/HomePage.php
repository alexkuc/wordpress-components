<?php

namespace WpComponents\Router\Routes;

use WpComponents\Router\Utilities\PseudoRoute;

/**
 * Home Page route
 */
class HomePage extends PseudoRoute
{

    public function getTemplatePath(): string
    {
        return 'home_page/index';
    }

}
