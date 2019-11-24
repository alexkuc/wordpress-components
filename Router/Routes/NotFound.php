<?php

namespace WpComponents\Router\Routes;

use WpComponents\Router\Utilities\PseudoRoute;

/**
 * 404 route
 */
class NotFound extends PseudoRoute
{

    public function getTemplatePath(): string
    {
        return '404/404';
    }

}
