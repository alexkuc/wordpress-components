<?php

namespace WpComponents\Content\PostTypes;

use WpComponents\Content\Utilities\PostType;

/**
 * Information custom post class
 */
class Information extends PostType {
    public function __construct() {
        parent::__construct("cpt_information");
    }

    protected function providePostData(): array
    {
        return [
            'labels' => [
                'name' => 'Information',
            ],
            'taxonomies' => [
                'tax_information',
            ],
        ];
    }
}
