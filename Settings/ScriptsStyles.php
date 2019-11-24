<?php

namespace WpComponents\WordPress;

/**
 * Deal with WordPress assets
 */
class ScriptsStyles
{

    public function addWpHooks(): self
    {
        if (is_admin() === false) {
            \add_action('init', [$this, 'addFrontendStyles']);
            \add_action('init', [$this, 'addFrontendScripts']);
        }

        return $this;
    }

    public function addWpFilters(): self
    {
        \add_filter('style_loader_tag', [$this, 'addIntegrityAttributes'], 10, 3);

        return $this;
    }

    public function addFrontendStyles(): void
    {
        wp_enqueue_style('main', get_stylesheet_uri());
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/dist/style.css');
        wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css');
        wp_enqueue_style('flag-icon', 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css');
    }

    public function addFrontendScripts(): void
    {
        wp_enqueue_script('main-js', get_template_directory_uri() . '/dist/main.js');
    }

    public function addIntegrityAttributes(string $tag, string $handle, string $src): string
    {
        $addAttribute = function(string $attr_name, string $attr_value) use (&$tag): void
        {
            $DOM = new \DOMDocument();
            $DOM->loadHTML($tag, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $DOM->firstChild->setAttribute($attr_name, $attr_value);
            $tag = $DOM->saveHTML();
        };

        switch ($handle) {

            case 'font-awesome':

                $addAttribute(
                    'integrity',
                    'sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay',
                );

                $addAttribute(
                    'crossorigin',
                    'anonymous',
                );

                break;

            case 'flag-icon':

                $addAttribute(
                    'integrity',
                    'sha256-NkXMfPcpoih3/xWDcrJcAX78pHpfwxkhNj0bAf8AMTs=',
                );

                $addAttribute(
                    'crossorigin',
                    'anonymous',
                );

                break;
        }

        return $tag;
    }

}
