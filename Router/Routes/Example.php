<?php

namespace WpComponents\Router\Routes;

use WpComponents\Router\Utilities\PseudoRoute;

/**
 * Example route
 */
class Example extends PseudoRoute
{

    public function getTemplatePath(): string
    {
        return 'example/example';
    }

}
