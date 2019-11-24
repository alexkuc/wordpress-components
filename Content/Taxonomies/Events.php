<?php

namespace WpComponents\Content\Taxonomies;

use WpComponents\Content\Utilities\Taxonomy;

/**
 * Events taxonomy class
 */
class Events extends Taxonomy {
    public function __construct() {
        parent::__construct(
            'tax_events',
            [
                'terms' => array(
                    'Webinars',
                    'Seminars',
                ),
                'quicklink_type' => Taxonomy::NONE
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
