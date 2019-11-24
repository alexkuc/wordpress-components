<?php

namespace WpComponents;

require __DIR__ . '/vendor/autoload.php';

use WpComponents\Router\Routes\{
    Sitemap,
    Example,
    HomePage,
    NotFound,
    SinglePost,
    TaxTermArchive,
    PostTypeArchive,
};
use WpComponents\Router\Utilities\PseudoRouter;
use WpComponents\Templates\Utilities\TemplateEngine;

$engine = new TemplateEngine();
$router = new PseudoRouter('sections/');

// templates
$router->addRoute('is_home', new HomePage());
$router->addRoute('is_post_type_archive', new PostTypeArchive());
$router->addRoute('is_tax', new TaxTermArchive());
$router->addRoute('is_single', new SinglePost());
$router->addRoute('is_404', new NotFound());
// catch-all route is router fails to find a mapped path
// there is a catch though: if you try to access non-existing
// post, WordPress will automatically default to 404 which
// may give a false impression that default route does not work
$router->addRoute('default', new HomePage());

// specific pages
// this example shows how to render dynamic data
$router->addRoute('example.php', new Example());
$router->addRoute('example.html', new Example());
// this example shows a rudimentary sitemap
$router->addRoute('sitemap.php', new Sitemap());
$router->addRoute('sitemap.html', new Sitemap());

$router->getRoute()->loadRoute();
