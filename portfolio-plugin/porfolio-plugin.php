<?php 

/**
 * @package Portfolio Plugin
 */
/*
Plugin Name: The Portfolio Manager
Plugin URI: https://google.com/
Description: Very cool plugin. 
Version: 1.0.0
Author: Damjan
Author URI: https://google.com
*/
?>

<?php 

if(!function_exists('porfolio_plugin')){
    function portfolio_plugin(){

        $labels = array(
            'name'                     => 'Portfolios',
            'singular_name'            => 'Portfolio',
            'add_new'                  => 'Add New Portfolio',
            'add_new_item'             => 'Add New Portfolio',
            'edit_item'                => 'Edit Portfolio',
            'new_item'                 => 'New Portfolio',
            'view_item'                => 'View Portfolio',
            'view_items'               => 'View Portfolios',
            'search_items'             => 'Search Portfolios',
            'all_items'                => 'All Portfolios'

        );

        register_post_type('porfolio_plugin', array(
            'label' => 'Portfolio',
            'labels' => $labels,
            'public' => true,
            'menu_icon' => 'dashicons-pinterest',
            'capability_type' => 'post',
            'capabilities' => array(
                'edit_post' => 'edit_portfolio',
                'edit_posts' => 'edit_portfolios',
                'edit_others_posts' => 'edit_other_portfolios', 
                'publish_posts' => 'publish_portfolios',
                'read_posts' => 'read_portfolios',
                'read_private_posts' => 'read_private_portfolios', 
                'delete_post' => 'delete_portfolio'
            )
        ));

        function add_portfolio_admin(){
            $role = get_role('administrator');
            $role->add_cap('edit_portfolio');
            $role->add_cap('edit_portfolios');
            $role->add_cap('edit_other_portfolio');
            $role->add_cap('publish_portfolios');
            $role->add_cap('read_portfolios');
            $role->add_cap('read_private_portfolios');
            $role->add_cap('delete_portfolio');
            $role->add_cap('edit_published_portfolios');
            $role->add_cap('delete_published_portfolios');
        }

        add_action('admin_init', 'add_portfolio_admin');
}
}

add_action('init','portfolio_plugin');
register_activation_hook(__FILE__, 'portfolio_plugin');

if(!function_exists('portfolio_taxonomy')){
    function portfolio_taxonomy(){
    //Taxonomy name: Type
    //Related to: Portfolio

    $taxonomy_name = 'type';

        $labels = array(
            'name' => _x('Portfolio Types', 'Type of Portfolios'),
            'search_items' => __('Search Portfolios'),
            'parent_item' => __('Parent Type'),
            'all_items' => __('All Types'),
            'edit_item' => __('Edit Type'),
            'update_item' => __('Update Type'),
            'delete_item' => __('Delete Type'),
            'add_new_item' => __('Add New Type'),
            'new_item_name' => __('New Type Name'),
            'manu_name' => __('Portfolio Types')
        );

        register_taxonomy($taxonomy_name, array('portfolio_taxonomy'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'type')
        ));

        add_action('init','portfolio_taxonomy');
}
}

if(!function_exists('portfolio_plugin_deactivate')){
    function portfolio_plugin_deactivate(){
        unregister_post_type('portfolio_plugin');
        flush_rewrite_rules();
    }
}

register_deactivation_hook(__FILE__ ,'portfolio_plugin_deactivate');