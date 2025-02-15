<?php
/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    product_estimate
 * @subpackage product_estimate/includes
 *
 * created 2/14/25019
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    product_estimate
 * @subpackage product_estimate/includes
 * @author     Your Name <email@example.com>
 */
class WC_ES_Activator{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate(){

        self::create_estimate_template_page();
        self::create_estimate_list_template_page();
        self::create_estimate_edit_template_page();
        self::create_estimate_quote_template_page();
        //self::create_signup_templete_page();
        self::add_table();
        self::add_role();
        self::add_cap();
        self::updateOptions();
    }

    // private static function create_estimate_templete_page(){
    //     // Create post object
    //     $new_page_title = 'Product Estimate';
    //     $new_page_content = 'Product Estimate';
    //     $new_page_template = 'estimate.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
    //     //don't change the code bellow, unless you know what you're doing
    //     $page_check = get_page_by_title($new_page_title);

    //     $my_post = array(
    //         'post_title' => $new_page_title,
    //         'post_content' => $new_page_content,
    //         'page_template' => 'Estimate',
    //         'post_status' => 'publish',
    //         'post_name' => 'estimate',
    //         'post_type' => 'page',
    //         'post_author' => 1,
    //     );

    //     // Insert the post into the database

    //     if (!isset($page_check->ID)) {
    //         $new_page_id = wp_insert_post($my_post);;
    //         if (!empty($new_page_template)) {
    //             update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
    //         }
    //     }
    // }

    private static function create_estimate_template_page() {
        // Create post object
        $new_page_title = 'Product Estimate';
        $new_page_content = 'Product Estimate';
        $new_page_template = 'estimate.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.

        // Check if the page already exists
        $page_check = new WP_Query(array(
            'post_type' => 'page',
            'post_title' => $new_page_title,
        ));

        if (!$page_check->have_posts()) {
            $my_post = array(
                'post_title'   => $new_page_title,
                'post_content' => $new_page_content,
                'post_status'  => 'publish',
                'post_name'    => 'estimate',
                'post_type'    => 'page',
                'post_author'  => 1,
            );

            // Insert the post into the database
            $new_page_id = wp_insert_post($my_post);

            if (!empty($new_page_template)) {
                update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
            }

            // Reset post data
            wp_reset_postdata();
        }
    }


    // private static function create_estimate_list_templete_page(){
    //     // Create post object
    //     $new_page_title = 'Product Estimate List';
    //     $new_page_content = 'Product Estimate List';
    //     $new_page_template = 'estimate_list.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
    //     //don't change the code bellow, unless you know what you're doing
    //     $page_check = get_page_by_title($new_page_title);

    //     $my_post = array(
    //         'post_title' => $new_page_title,
    //         'post_content' => $new_page_content,
    //         'page_template' => 'Estimate List',
    //         'post_status' => 'publish',
    //         'post_name' => 'estimate_list',
    //         'post_type' => 'page',
    //         'post_author' => 1,
    //     );

    //     // Insert the post into the database

    //     if (!isset($page_check->ID)) {
    //         $new_page_id = wp_insert_post($my_post);;
    //         if (!empty($new_page_template)) {
    //             update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
    //         }
    //     }
    // }

    private static function create_estimate_list_template_page() {
        // Create post object
        $new_page_title = 'Product Estimate List';
        $new_page_content = 'Product Estimate List';
        $new_page_template = 'estimate_list.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.

        // Check if the page already exists
        $page_check = new WP_Query(array(
            'post_type' => 'page',
            'post_title' => $new_page_title,
        ));

        if (!$page_check->have_posts()) {
            $my_post = array(
                'post_title'   => $new_page_title,
                'post_content' => $new_page_content,
                'post_status'  => 'publish',
                'post_name'    => 'estimate_list',
                'post_type'    => 'page',
                'post_author'  => 1,
            );

            // Insert the post into the database
            $new_page_id = wp_insert_post($my_post);

            if (!empty($new_page_template)) {
                update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
            }

            // Reset post data
            wp_reset_postdata();
        }
    }


    // private static function create_estimate_edit_templete_page(){
    //     // Create post object
    //     $new_page_title = 'Product Estimate Edit';
    //     $new_page_content = 'Product Estimate Edit';
    //     $new_page_template = 'estimate_edit.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
    //     //don't change the code bellow, unless you know what you're doing
    //     $page_check = get_page_by_title($new_page_title);

    //     $my_post = array(
    //         'post_title' => $new_page_title,
    //         'post_content' => $new_page_content,
    //         'page_template' => 'Estimate Edit',
    //         'post_status' => 'publish',
    //         'post_name' => 'estimate_edit',
    //         'post_type' => 'page',
    //         'post_author' => 1,
    //     );

    //     // Insert the post into the database

    //     if (!isset($page_check->ID)) {
    //         $new_page_id = wp_insert_post($my_post);;
    //         if (!empty($new_page_template)) {
    //             update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
    //         }
    //     }
    // }

    private static function create_estimate_edit_template_page() {
        // Create post object
        $new_page_title = 'Product Estimate Edit';
        $new_page_content = 'Product Estimate Edit';
        $new_page_template = 'estimate_edit.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.

        // Check if the page already exists
        $page_check = new WP_Query(array(
            'post_type' => 'page',
            'post_title' => $new_page_title,
        ));

        if (!$page_check->have_posts()) {
            $my_post = array(
                'post_title'   => $new_page_title,
                'post_content' => $new_page_content,
                'post_status'  => 'publish',
                'post_name'    => 'estimate_edit',
                'post_type'    => 'page',
                'post_author'  => 1,
            );

            // Insert the post into the database
            $new_page_id = wp_insert_post($my_post);

            if (!empty($new_page_template)) {
                update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
            }

            // Reset post data
            wp_reset_postdata();
        }
    }


    // private static function create_estimate_quote_templete_page(){
    //     // Create post object
    //     $new_page_title = 'Product Estimate Quote';
    //     $new_page_content = 'Product Estimate Quote';
    //     $new_page_template = 'estimate_quote.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
    //     //don't change the code bellow, unless you know what you're doing
    //     $page_check = get_page_by_title($new_page_title);

    //     $my_post = array(
    //         'post_title' => $new_page_title,
    //         'post_content' => $new_page_content,
    //         'page_template' => 'Estimate Quote',
    //         'post_status' => 'publish',
    //         'post_name' => 'estimate_quote',
    //         'post_type' => 'page',
    //         'post_author' => 1,
    //     );

    //     // Insert the post into the database

    //     if (!isset($page_check->ID)) {
    //         $new_page_id = wp_insert_post($my_post);;
    //         if (!empty($new_page_template)) {
    //             update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
    //         }
    //     }
    // }

    private static function create_estimate_quote_template_page() {
        // Create post object
        $new_page_title = 'Product Estimate Quote';
        $new_page_content = 'Product Estimate Quote';
        $new_page_template = 'estimate_quote.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.

        // Check if the page already exists
        $page_check = new WP_Query(array(
            'post_type' => 'page',
            'post_title' => $new_page_title,
        ));

        if (!$page_check->have_posts()) {
            $my_post = array(
                'post_title'   => $new_page_title,
                'post_content' => $new_page_content,
                'post_status'  => 'publish',
                'post_name'    => 'estimate_quote',
                'post_type'    => 'page',
                'post_author'  => 1,
            );

            // Insert the post into the database
            $new_page_id = wp_insert_post($my_post);

            if (!empty($new_page_template)) {
                update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
            }

            // Reset post data
            wp_reset_postdata();
        }
    }


    // private static function create_signup_templete_page(){
    //     // Create post object
    //     $new_page_title = 'Estimate Sign Up';
    //     $new_page_content = 'Estimate Sign Up';
    //     $new_page_template = 'signup.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
    //     //don't change the code bellow, unless you know what you're doing
    //     $page_check = get_page_by_title($new_page_title);

    //     $my_post = array(
    //         'post_title' => $new_page_title,
    //         'post_content' => $new_page_content,
    //         'page_template' => 'Sign Up',
    //         'post_status' => 'publish',
    //         'post_name' => 'signup',
    //         'post_type' => 'page',
    //         'post_author' => 1
    //     );

    //     // Insert the post into the database

    //     if (!isset($page_check->ID)) {
    //         $new_page_id = wp_insert_post($my_post);;
    //         if (!empty($new_page_template)) {
    //             update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
    //         }
    //     }
    // }

    private static function add_role(){
        add_role(
            'Estimate-admin',
            __('Estimate Admin'),
            array(
                'read' => false,  // true allows this capability
                'edit_posts' => false
            )
        );
        add_role(
            'product-manager',
            __('Product Manager'),
            array(
                'read' => true,  // true allows this capability
                'edit_posts' => true,
                'delete_products' => true,
                'edit_products' => true,
                'delete_products' => true,
                'edit_product' => true,
                'edit_others_products' => true,
                'edit_private_products' => true,
                'edit_published_products' => true,
                'manage_product_terms' => true,
                'edit_product_terms' => true,
                'view_admin_dashboard' => true,
                'view_woocommerce_reports' => true
            )
        );
        add_role(
            'order-manager',
            __('Order Manager'),
            array(
                'read' => true,  // true allows this capability
                'edit_posts' => true,
                'edit_posts' => true,
                'read_shop_order' => true,
                'read_shop_orders' => true,
                'edit_shop_orders' => true,
                'edit_publish_shop_orders' => true,
                'edit_private_shop_orders' => true,
                'edit_others_shop_orders' => true,
                'manage_shop_order_terms' => true,
                'edit_shop_order' => true,
                'publish_shop_orders' => true,
                // 'delete_shop_order' => true,
                'view_admin_dashboard' => true,
                'view_woocommerce_reports' => true
            )
        );
        add_role(
            'normal-user',
            __('Normal Users'),
            array(
                'read' => true,  // true allows this capability
                'edit_posts' => true
            )
        );
    }

    // Add the new capability to all roles having a certain built-in capability
    private static function add_cap()
    {
        $roles = get_editable_roles();
        foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
            if (isset($roles[$key]) && $role->has_cap('estimate-admin')) {
                $role->add_cap('estimate-admin');
            }
            if (isset($roles[$key]) && $role->has_cap('order-manager')) {
                $role->add_cap('order-manager');
            }
        }
    }

    private static function add_table(){

        global $wpdb;

        $estimate = $wpdb->prefix . 'innovs_wc_es';

        $estimate_products = $wpdb->prefix . 'innovs_wc_es_products';
        $estimate_products_qoute = $wpdb->prefix . 'innovs_wc_es_quote';
        $quote_details = $wpdb->prefix . 'innovs_product_quote_details';

        if ($wpdb->get_var("SHOW TABLES LIKE '$estimate'") != $estimate) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $estimate (
			id mediumint(9) NOT NULL AUTO_INCREMENT, 
			user_id varchar(200) NOT NULL,
			estimate_name varchar(200) NOT NULL,
			estimate_description text NOT NULL,
			user_name varchar(200) NOT NULL,
			user_email varchar(200) NOT NULL,
			user_contact_person varchar(100) NOT NULL,
			user_contact varchar(55) NOT NULL,
			user_address text NOT NULL,
			cdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY  (id)
			) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$estimate_products'") != $estimate_products) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql2 = "CREATE TABLE $estimate_products (
            id mediumint(9) NOT NULL AUTO_INCREMENT, 
            estimate_id mediumint(11) NOT NULL,
            product_id mediumint(11) NOT NULL,
            product_name varchar(200) NOT NULL,
            qty varchar(200) NOT NULL,
            price varchar(55) NOT NULL,
            total_price text NOT NULL,
            cdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql2);

        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$estimate_products_qoute'") != $estimate_products_qoute) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql3 = "CREATE TABLE $estimate_products_qoute (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`estimate_id` int(11) NOT NULL,
			`product_id` int(11) NOT NULL,
			`name` varchar(250) NOT NULL,
			`email` varchar(250) NOT NULL,
			`phone` varchar(250) NOT NULL,
			`address` varchar(250) NOT NULL,
			`city` varchar(250) NOT NULL,
			`state` varchar(250) NOT NULL,
			`post_code` varchar(250) NOT NULL,
			`country` varchar(250) NOT NULL,
			`product` varchar(250) NOT NULL,
			`quantity` int(11) NOT NULL,
			`additional_info` varchar(250) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
			)$charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql3);

        }
        if ($wpdb->get_var("SHOW TABLES LIKE '$quote_details'") != $quote_details) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql4 = "CREATE TABLE $quote_details (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`quote_id` int(11) NOT NULL,
			`product_name` varchar(250) NOT NULL,
			`qty` int(11) NOT NULL,
			`price` int(11) NOT NULL,
			`total_price` int(11) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
			)$charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql4);

        }
    }

    private static function updateOptions(){
        update_option('primary_color', '#dd3333');
        update_option('button_color', '#81d742');
        update_option('seccondary_color', '#1941b7');
        update_option('hover_color', '#eaed49');
        update_option('company_name', 'TheInnovs');
        update_option('delete_time', '7');
        update_option('estimate_limit', '10');
        update_option('estimate_export_footer', 'This Price Estimate does not constitute an offer by TheInnovs to sell products, but is instead an invitation to issue a purchase order to TheInnovs until the valid date specified in this Price Estimate.Such a purchase order will be subject to Cisco standard procedures, terms and conditions for the acceptance of purchase orders.This order may subject to sales tax, VAT, duty and freight charges even if not noted on this estimate. ');
        update_option('estimate_menu', '1');
        update_option('per_page', '25');
        update_option('estimate_list', 'estimate_list');
        update_option('create_estimate', 'estimate');
        update_option('estimate_category1', 'device');
        update_option('estimate_category2', 'sensore');
        update_option('set_currency', '$');
    }
}
?>