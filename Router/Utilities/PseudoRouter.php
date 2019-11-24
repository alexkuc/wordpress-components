<?php

namespace WpComponents\Router\Utilities;

use WpComponents\Templates\Utilities\TemplateEngine;

/**
 * Pseudo router to load templates in polymorphic manner
 */
class PseudoRouter
{

    private $routes;

    private $engine;

    private $wp_query;

    private $path_prefix;

    private $current_route;

    private $wp_query_filter = [
        'is_tax',
        'is_404',
        'is_home',
        'is_single',
        'is_post_type_archive',
    ];

    public function __construct(string $path_prefix = '')
    {
        $this->engine = new TemplateEngine();
        $this->wp_query = $GLOBALS['wp_query'];
        $this->path_prefix = $path_prefix;
    }

    public function getRoute(): self
    {
        $pagename = $this->getWpQueryPagename();
        $route = $this->getWpQueryTemplate();

        if (!empty($pagename))
        {
            $this->current_route = $pagename;
        }
        elseif (!empty($route))
        {
            $this->current_route = $route;
        }
        else
        {
            $this->current_route = 'default';
        }

        return $this;
    }

    public function loadRoute(string $route_name = null): void
    {
        $route = $route_name ?? $this->current_route;
        $route_class =  $this->routes[$route];
        $template_path = $this->path_prefix . $route_class->getTemplatePath();
        $this->engine->renderTemplate($template_path);
    }

    private function getWpQueryKeys(): array
    {
        return array_keys(
            get_object_vars($this->wp_query)
        );
    }

    private function getWpQueryPagename(): ?string
    {
        $pagename = $GLOBALS['wp_query']->query['pagename'] ?? null;

        if (!empty($pagename) &&
            in_array($pagename, array_keys($this->routes)))
        {
            return $pagename;
        } else
        {
            return null;
        }
    }

    private function getWpQueryTemplate(): ?string
    {
        $return = array_values(
            array_filter($this->getWpQueryKeys(), function($i)
            {
                if (!in_array($i, $this->wp_query_filter))
                {
                    return false;
                }
                else
                {
                    return $this->wp_query->{$i};
                }
            }
        ))[0];

        if (!empty($return))
        {
            return $return;
        } else
        {
            return null;
        }
    }

    public function addRoute(string $route_name, object $route_class): void
    {
        $this->routes[$route_name] = $route_class;
    }

}
