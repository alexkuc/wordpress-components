<?php

namespace WpComponents\Content\Utilities;

abstract class Taxonomy {
    public const NONE = "none";
    public const INLINE = "inline";
    public const DROPDOWN = "dropdown";

    private $taxKey;

    /**
     * @var string[]
     */
    private $predefinedTypes;

    /**
     * @var string
     */
    private $quickLinkType;

    /**
     * The options array can be used to add taxonomy subtypes
     */
    public function __construct(string $taxKey, array $options = []) {
        $this->taxKey = $taxKey;

        if(array_key_exists('terms', $options)) {
            $this->predefinedTypes = $options['terms'];
        } else {
            $this->predefinedTypes = [];
        }

        if(array_key_exists('quicklink_type', $options)) {
            $val = $options['quicklink_type'];
            if(!in_array($val, [Taxonomy::DROPDOWN, Taxonomy::INLINE, Taxonomy::NONE])) {
                    throw new Error('Unknown quicklink type: ' . $val);
                }

            $this->quickLinkType = $options['quicklink_type'];
        } else {
            $this->quickLinkType = self::INLINE;
        }
    }

    private static function default_labels($args = null, $text_domain = null) {
        $args['name'] = $args['name'] ?? 'Taxonomies';
        $args['singular_name'] = $args['singular_name'] ?? 'Taxonomy';
        $args['menu_name'] = $args['menu_name'] ?? 'Taxonomy';
        $args['all_items'] = $args['all_items'] ?? 'All Items';
        $args['parent_item'] = $args['parent_item'] ?? 'Parent Item';
        $args['parent_item_colon'] = $args['parent_item_colon'] ?? 'Parent Item:';
        $args['new_item_name'] = $args['new_item_name'] ?? 'New Item Name';
        $args['add_new_item'] = $args['add_new_item'] ?? 'Add New Item';
        $args['edit_item'] = $args['edit_item'] ?? 'Edit Item';
        $args['update_item'] = $args['update_item'] ?? 'Update Item';
        $args['view_item'] = $args['view_item'] ?? 'View Item';
        $args['separate_items_with_commas'] = $args['separate_items_with_commas'] ?? 'Separate Items With Commas';
        $args['add_or_remove_items'] = $args['add_or_remove_items'] ?? 'Add Or Remove Items';
        $args['choose_from_most_used'] = $args['choose_from_most_used'] ?? 'Choose From The Most Used';
        $args['popular_items'] = $args['popular_items'] ?? 'Popular Items';
        $args['search_items'] = $args['search_items'] ?? 'Search Items';
        $args['not_found'] = $args['not_found'] ?? 'Not Found';
        $args['no_terms'] = $args['no_terms'] ?? 'No Items';
        $args['items_list'] = $args['items_list'] ?? 'Items List';
        $args['items_list_navigation'] = $args['items_list_navigation'] ?? 'Items List Navigation';

        $labels = array(
            'name' => _x($args['name'], 'Taxonomy General Name', $text_domain),
            'singular_name' => _x($args['singular_name'], 'Taxonomy Singular Name', $text_domain),
            'menu_name' => __($args['menu_name'], $text_domain),
            'all_items' => __($args['all_items'], $text_domain),
            'parent_item' => __($args['parent_item'], $text_domain),
            'parent_item_colon' => __($args['parent_item_colon'], $text_domain),
            'new_item_name' => __($args['new_item_name'], $text_domain),
            'add_new_item' => __($args['add_new_item'], $text_domain),
            'edit_item' => __($args['edit_item'], $text_domain),
            'update_item' => __($args['update_item'], $text_domain),
            'view_item' => __($args['view_item'], $text_domain),
            'separate_items_with_commas' => __($args['separate_items_with_commas'], $text_domain),
            'add_or_remove_items' => __($args['add_or_remove_items'], $text_domain),
            'choose_from_most_used' => __($args['choose_from_most_used'], $text_domain),
            'popular_items' => __($args['popular_items'], $text_domain),
            'search_items' => __($args['search_items'], $text_domain),
            'not_found' => __($args['not_found'], $text_domain),
            'no_terms' => __($args['no_terms'], $text_domain),
            'items_list' => __($args['items_list'], $text_domain),
            'items_list_navigation' => __($args['items_list_navigation'], $text_domain),
        );

        return $labels;
    }

    private static function default_args($args = null, $labels = null) {

        $args['labels'] = $args['labels'] ?? $labels ?? static::default_labels();
        $args['hierarchical'] = $args['hierarchical'] ?? false;
        $args['public'] = $args['public'] ?? true;
        $args['show_ui'] = $args['show_ui'] ?? true;
        $args['show_admin_column'] = $args['show_admin_column'] ?? true;
        $args['show_in_nav_menus'] = $args['show_in_nav_menus'] ?? true;
        $args['show_tagcloud'] = $args['show_tagcloud'] ?? true;
        $args['show_in_rest'] = $args['show_in_rest'] ?? true;
        $args['radio_buttons'] = $args['radio_buttons'] ?? true;

        return $args;
    }

    protected abstract function provideTaxonomyData(): array;

    public function getWPArguments(): array
    {
        /**
         * It's important here that the second argument is the
         * user provided data because we want it to override defaults.
         */
        return array_merge(
            static::default_args(),
            $this->provideTaxonomyData()
        );
    }

    /**
     * Returns the Taxonomy key
     * @return string the taxonomy name
     */
    public function getKey(): string {
        return $this->taxKey;
    }

    /**
     * Get the Taxonomy predefined terms
     * @return array the array of predefined types
     */
    public function getTerms(): array {
        return $this->predefinedTypes;
    }

    /**
     * Returns how this taxonomy should be rendered as a link
     * @return string the quick link type
     */
    public function getQuickLinkType(): string {
        return $this->quickLinkType;
    }
}

?>
