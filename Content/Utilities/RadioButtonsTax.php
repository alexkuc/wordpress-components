<?php

namespace WpComponents\Content\Utilities;

/**
 * Update options for plugin 'Radio Buttons for Taxonomies'
 *   to programmatically enable/disable plugin for specific
 *   taxonomies to show (or not) radio buttons
 */
class RadioButtonsTax {

    public const OPTION_NAME = 'radio_button_for_taxonomies_options';
    private const DEFAULT_VALUE = array(
        'taxonomies' => array(),
        'delete' => 1,
    );
    private $taxonomy;

    public function __construct(string $taxonomy) {
        $this->taxonomy = $taxonomy;
    }

    private function get(): array{
        return \get_option(self::OPTION_NAME, self::DEFAULT_VALUE);
    }

    private function set(array $new_val): void {
        \update_option(self::OPTION_NAME, $new_val, 'yes');
    }

    public function enable(): void{
        $option = $this->get();
        if (!in_array($this->taxonomy, $option['taxonomies'])) {
            array_push($option['taxonomies'], $this->taxonomy);
        }
        $this->set($option);
    }

    public function disable(): void {
        $option = $this->get();
        if (in_array($this->taxonomy, $option['taxonomies'])) {
            $key = array_keys($option['taxonomies'], $this->taxonomy, true)[0];
            unset($option['taxonomies'][$key]);
        }
        $this->set($option);
    }

}
