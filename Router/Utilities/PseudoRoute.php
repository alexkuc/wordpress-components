<?php

namespace WpComponents\Router\Utilities;

/**
 * Pseudo route for pseudo router
 */
abstract class PseudoRoute
{
    abstract public function getTemplatePath(): string;
}
