<?php

namespace WpComponents\Content\PostTypes;

use WpComponents\Content\Utilities\PostType;

/**
 * Events custom post class
 */
class Events extends PostType {
    public function __construct() {
        parent::__construct("cpt_events");
    }

    protected function providePostData(): array
    {
        return [
            'labels' => [
                'name' => 'Events',
            ],
            'taxonomies' => [
                'tax_events',
            ],
        ];
    }
}
