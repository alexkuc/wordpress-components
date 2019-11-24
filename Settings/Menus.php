<?php

namespace WpComponents\WordPress;

/**
 * Modify WordPress admin menus (wp-admin)
 */
class Menus
{

    public function addWpHook(): void
    {
        \add_action('admin_menu', [$this,'hideAdminMenus']);
    }

    public function hideAdminMenus(): void
    {
        // Remove Posts page from admin UI
        remove_menu_page('edit.php');

        // Pages Posts page from admin UI
        remove_menu_page('edit.php?post_type=page');

        // Comments Posts page from admin UI
        remove_menu_page('edit-comments.php');
    }

}
