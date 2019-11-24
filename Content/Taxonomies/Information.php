<?php

namespace WpComponents\Content\Taxonomies;

use WpComponents\Content\Utilities\Taxonomy;

/**
 * Information taxonomy class
 */
class Information extends Taxonomy {
    public function __construct() {
        parent::__construct(
            'tax_information',
            [
                'terms' => array(
                    'Knowledge Base',
                    'Guidelines',
                    'FAQ',
                ),
                'quicklink_type' => Taxonomy::INLINE
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

