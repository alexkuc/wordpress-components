<?php

namespace WpComponents\Content\Taxonomies;

use WpComponents\Content\Utilities\Taxonomy;

/**
 * About Us taxonomy class
 */
class AboutUs extends Taxonomy {
    public function __construct() {
        parent::__construct(
            'tax_about_us',
            [
                'terms' => array(
                    'Corporate News',
                    'Clients',
                    'Partners',
                    'About Us',
                ),
                'quicklink_type' => Taxonomy::DROPDOWN,
                'radio_buttons' => true
            ]
        );
    }

    protected function provideTaxonomyData(): array
    {
        return [
            'labels' => [
                'name' => 'Sections',
            ],
        ];
    }
}
