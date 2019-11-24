<?php

namespace WpComponents\Content\PostTypes;

use WpComponents\Content\Utilities\PostType;

/**
 * About Us custom post class
 */
class AboutUs extends PostType {
    public function __construct() {
        parent::__construct("cpt_about_us");
    }

    protected function providePostData(): array
    {
        return [
            'labels' => [
                'name' => 'About Us',
            ],
            'taxonomies' => [
                'tax_about_us',
            ],
        ];
    }
}
