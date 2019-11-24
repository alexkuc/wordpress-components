<?php

namespace WpComponents\Content\Utilities;

abstract class PostType {
    /**
     * The name of this post type to be used
     * @var string
     */
    protected $postTypeKey;

    private static function default_labels($args = null, $text_domain = null) {
        $args['name'] = $args['name'] ?? 'Post Types';
        $args['singular_name'] = $args['singular_name'] ?? 'Post Type';
        $args['menu_name'] = $args['menu_name'] ?? 'Post Types';
        $args['name_admin_bar'] = $args['name_admin_bar'] ?? 'Post Type';
        $args['archives'] = $args['archives'] ?? 'Item Archives';
        $args['parent_item_colon'] = $args['parent_item_colon'] ?? 'Parent Item:';
        $args['all_items'] = $args['all_items'] ?? 'All Items';
        $args['add_new_item'] = $args['add_new_item'] ?? 'Add New Item';
        $args['add_new'] = $args['add_new'] ?? 'Add New';
        $args['new_item'] = $args['new_item'] ?? 'New Item';
        $args['edit_item'] = $args['edit_item'] ?? 'Edit Item';
        $args['update_item'] = $args['update_item'] ?? 'Update Item';
        $args['view_item'] = $args['view_item'] ?? 'View Item';
        $args['search_items'] = $args['search_items'] ?? 'Search Items';
        $args['not_found'] = $args['not_found'] ?? 'Not Found';
        $args['not_found_in_trash'] = $args['not_found_in_trash'] ?? 'Not Found In Trash';
        $args['featured_image'] = $args['featured_image'] ?? 'Featured Image';
        $args['set_featured_image'] = $args['set_featured_image'] ?? 'Set Featured Image';
        $args['remove_featured_image'] = $args['remove_featured_image'] ?? 'Remove Featured Image';
        $args['use_featured_image'] = $args['use_featured_image'] ?? 'Use Featured Image';
        $args['insert_into_item'] = $args['insert_into_item'] ?? 'Insert Into Item';
        $args['uploaded_to_this_item'] = $args['uploaded_to_this_item'] ?? 'Uploaded To This Item';
        $args['items_list'] = $args['items_list'] ?? 'Items List';
        $args['items_list_navigation'] = $args['items_list_navigation'] ?? 'Items List Navigation';
        $args['filter_items_list'] = $args['filter_items_list'] ?? 'Filter Items List';
        $args['description'] = $args['description'] ?? 'Post Type Description';

        $labels = array(
            'name' => _x($args['name'], 'Post Type General Name', $text_domain),
            'singular_name' => _x($args['singular_name'], 'Post Type Singular Name', $text_domain),
            'menu_name' => _x($args['menu_name'], 'Admin Menu Text', $text_domain),
            'name_admin_bar' => _x($args['name_admin_bar'], 'Add New on Toolbar', $text_domain),
            'archives' => __($args['archives'], $text_domain),
            'parent_item_colon' => __($args['parent_item_colon'], $text_domain),
            'all_items' => __($args['all_items'], $text_domain),
            'add_new_item' => __($args['add_new_item'], $text_domain),
            'add_new' => __($args['add_new'], $text_domain),
            'new_item' => __($args['new_item'], $text_domain),
            'edit_item' => __($args['edit_item'], $text_domain),
            'update_item' => __($args['update_item'], $text_domain),
            'view_item' => __($args['view_item'], $text_domain),
            'search_items' => __($args['search_items'], $text_domain),
            'not_found' => __($args['not_found'], $text_domain),
            'not_found_in_trash' => __($args['not_found_in_trash'], $text_domain),
            'featured_image' => __($args['featured_image'], $text_domain),
            'set_featured_image' => __($args['set_featured_image'], $text_domain),
            'remove_featured_image' => __($args['remove_featured_image'], $text_domain),
            'use_featured_image' => __($args['use_featured_image'], $text_domain),
            'insert_into_item' => __($args['insert_into_item'], $text_domain),
            'uploaded_to_this_item' => __($args['uploaded_to_this_item'], $text_domain),
            'items_list' => __($args['items_list'], $text_domain),
            'items_list_navigation' => __($args['items_list_navigation'], $text_domain),
            'filter_items_list' => __($args['filter_items_list'], $text_domain),
            'description' => __($args['description'], $text_domain),
        );

        return $labels;
    }

    private static function default_args($args = null, $labels = null) {

        $args['description'] = $args['description'] ?? $labels['description'] ?? static::default_labels()['description'];
        $args['labels'] = $args['labels'] ?? $labels ?? static::default_labels();
        $args['show_in_rest'] = $args['show_in_rest'] ?? true;
        $args['supports'] = $args['supports'] ?? array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'trackbacks',
            'revisions',
            'custom-fields',
            'page-attributes',
            'post-formats',
        );
        $args['taxonomies'] = $args['taxonomies'] ?? array('category', 'post_tag');
        $args['hierarchical'] = $args['hierarchical'] ?? true;
        $args['public'] = $args['public'] ?? true;
        $args['show_ui'] = $args['show_ui'] ?? true;
        $args['show_in_menu'] = $args['show_in_menu'] ?? true;
        $args['menu_position'] = $args['menu_position'] ?? 20;
        $args['menu_icon'] = $args['menu_icon'] ?? 'dashicons-admin-post';
        $args['show_in_admin_bar'] = $args['show_in_admin_bar'] ?? true;
        $args['show_in_nav_menus'] = $args['show_in_nav_menus'] ?? true;
        $args['can_export'] = $args['can_export'] ?? true;
        $args['has_archive'] = $args['has_archive'] ?? true;
        $args['rewrite'] = $args['has_archive'] ?? true;
        $args['exclude_from_search'] = $args['exclude_from_search'] ?? false;
        $args['publicly_queryable'] = $args['publicly_queryable'] ?? true;
        $args['capability_type'] = $args['capability_type'] ?? 'post';

        return $args;
    }

    /**
     * We must provide a name for this post type
     */
    public function __construct(string $postTypeKey) {
        $this->postTypeKey = $postTypeKey;
    }

    /**
     * Each PostType must provide overrides
     * to the default data. This will be merged
     * with the WP defaults.
     */
    protected abstract function providePostData(): array;

    /**
     * Returns the array of arguments for the wp custom post function
     */
    public function getWPArguments(): array
    {
        /**
         * It's important here that the second argument is the
         * user provided data because we want it to override defaults.
         */
        return array_merge(
            static::default_args(),
            $this->providePostData()
        );
    }

    /**
     * Get the post name of WP custom post
     * @return string - the post name
     */
    public function getPostTypeKey(): string {
        return $this->postTypeKey;
    }
}

?>
