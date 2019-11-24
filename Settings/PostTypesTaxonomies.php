<?php

namespace WpComponents\Settings;

use WpComponents\Content\Utilities;
use WpComponents\Content\PostTypes;
use WpComponents\Content\Taxonomies;

/**
 * Specify custom post types and taxonomies definitions
 */
class PostTypesTaxonomies
{

    private $registry;

    public function __construct()
    {
        $this->registry = Utilities\Registry::instance();
    }

    public function loadDefinitions(): void
    {
        // add custom post types and taxonomies definitions
        $this->addDefinitions();
        $this->registry->passAlongToWP();

        // modify subsubsub menu (quicklinks)
        $this->registry->registerQuickLinks();
    }

    private function addDefinitions(): void
    {
        // About Us
        $this->registry->addTaxonomy(new Taxonomies\AboutUs());
        $this->registry->addPostType(new PostTypes\AboutUs());

        // Events
        $this->registry->addTaxonomy(new Taxonomies\Events());
        $this->registry->addPostType(new PostTypes\Events());

        // Information
        $this->registry->addTaxonomy(new Taxonomies\Information());
        $this->registry->addPostType(new PostTypes\Information());
    }

}
