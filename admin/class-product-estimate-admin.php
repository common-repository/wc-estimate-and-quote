<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wc_es
 * @subpackage wc_es/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    wc_es
 * @subpackage wc_es/admin
 * @author     Your Name <email@example.com>
 */
class WC_es_Admin{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $wc_es The ID of this plugin.
     */
    private $wc_es;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $innovs_wc_es The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($wc_es, $version){

        $this->wc_es = $wc_es;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles(){
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in innovs_wc_es_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The innovs_wc_es_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style($this->wc_es . 'product-estimate-bootstrap', plugin_dir_url(__FILE__) . 'css/product-estimate-bootstrap.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->wc_es . 'pqe-datatable.min', plugin_dir_url(__FILE__) . 'css/pqe-datatable.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->wc_es . 'admin', plugin_dir_url(__FILE__) . 'css/plugin-name-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts(){
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in innovs_wc_es_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The innovs_wc_es_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script('jquery');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script($this->wc_es . 'pe-bootstrap', plugin_dir_url(__FILE__) . 'js/pe-bootstrap.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->wc_es . 'pe-datatable', plugin_dir_url(__FILE__) . 'js/pe-data-table.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->wc_es . 'admin', plugin_dir_url(__FILE__) . 'js/product-estimate-admin.js', array('jquery'), $this->version, false);
        wp_localize_script($this->wc_es . 'admin', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    /**
     * Register a custom menu page.
     */
    public function wc_es_register_my_custom_menu_page(){
        add_menu_page(
            __('Product Estimate', 'innovs_wc_es'),
            'Product Estimate',
            'manage_options',
            'product-innovs_wc_es',
            array($this, 'wc_es_menu_page'),
            'dashicons-welcome-write-blog',
            // plugins_url( 'myplugin/images/icon.png' ),
            6
        );

        add_submenu_page('product-innovs_wc_es', 'Settings', 'Settings', 'manage_options', 'settings', array($this, 'wc_es_settings_menu_page'));

        add_submenu_page('product-innovs_wc_es', 'Quote', 'Quote', 'manage_options', 'Quote', array($this, 'wc_es_quote_menu_page'));
    }

    public function settings_custome_fileld_admin_init(){
        return wc_Estimate_Settings::register_settings_optings();
    }

    function wc_es_my_login_logo(){ ?>

        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?php echo plugin_dir_url( __FILE__ ); ?>/images/logo.svg);
                height: 65px;
                width: 320px;
                background-size: 320px 65px;
                background-repeat: no-repeat;
                padding-bottom: 0px;
                background-color: transparent;
                border-radius: 0;
            }

            #wpfooter p {
                font-size: 13px;
                margin: 0;
                line-height: 20px;
                display: none !important;
            }
        </style>

    <?php }

    function wc_es_demo_footer_filter($default)
    {
        return '';
    }

    function wc_es_remove_wp_logo($wp_admin_bar)
    {
        $wp_admin_bar->remove_node('wp-logo');
    }


    /**
     * Display a custom menu page
     */
    public function wc_es_menu_page(){
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/product_estimate.php';
    }

    public function wc_es_settings_menu_page(){
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/settings.php';
    }

    public function wc_es_quote_menu_page(){
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/quote.php';
    }

    public static function get_all_innovs_wc_es(){
        global $wpdb;
        // $current_user = get_current_user_id();
        $tablename = $wpdb->prefix . "innovs_wc_es";
        $ls_innovs_wc_es = $wpdb->get_results("SELECT * FROM $tablename ORDER BY id");

        return $ls_innovs_wc_es;
    }

    /**
     * Redirect users to custom URL based on their role after login
     *
     * @param string $redirect
     * @param object $user
     * @return string
     */
    public function wc_custom_user_redirect($redirect, $user){
        // Get the first of all the roles assigned to the user
        $role = $user->roles[0];
        $dashboard = admin_url();
        // $myaccount = get_permalink( wc_get_page_id( 'shop' ) );
        $myaccount = home_url();
        if ($role == 'administrator') {
            //Redirect administrators to the dashboard
            $redirect = $dashboard;
        } elseif ($role == 'shop-manager') {
            //Redirect shop managers to the dashboard
            $redirect = $dashboard;
        } elseif ($role == 'editor') {
            //Redirect editors to the dashboard
            $redirect = $dashboard;
        } elseif ($role == 'author' || $role == 'order-manager') {
            //Redirect authors to the dashboard
            $redirect = $dashboard;
        } elseif ($role == 'innovs_wc_es-admin' || $role == 'subscriber') {
            //Redirect customers and subscribers to the "My Account" page
            $redirect = $myaccount;
        } else {
            //Redirect any other role to the previous visited page or, if not available, to the home
            $redirect = wp_get_referer() ? wp_get_referer() : home_url();
        }
        return $redirect;
    }
    // add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );

// add_filter( 'woocommerce_register_shop_order_post_statuses', 'bbloomer_register_custom_order_status' );

    function wc_es_register_custom_order_status($order_statuses){

        // Status must start with "wc-"
        $order_statuses['wc-order-received'] = array(
            'label' => _x('Order Received', 'Order status', 'woocommerce'),
            'public' => false,
            'exclude_from_search' => false,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop('Order Received <span class="count">(%s)</span>', 'Order Received <span class="count">(%s)</span>', 'woocommerce'),
        );
        $order_statuses['wc-payment-received'] = array(
            'label' => _x('Payment Received', 'Order status', 'woocommerce'),
            'public' => false,
            'exclude_from_search' => false,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop('Payment Received <span class="count">(%s)</span>', 'Payment Received <span class="count">(%s)</span>', 'woocommerce'),
        );
        return $order_statuses;
    }

// ---------------------
// 2. Show Order Status in the Dropdown @ Single Order and "Bulk Actions" @ Orders

// add_filter( 'wc_order_statuses', 'bbloomer_show_custom_order_status' );

    function wc_es_show_custom_order_status($order_statuses){
        $order_statuses['wc-order-received'] = _x('Order Received', 'Order status', 'woocommerce');
        $order_statuses['wc-payment-received'] = _x('Payment Received', 'Order status', 'woocommerce');
        return $order_statuses;
    }

// add_filter( 'bulk_actions-edit-shop_order', 'bbloomer_get_custom_order_status_bulk' );

    function wc_es_get_custom_order_status_bulk($bulk_actions){
        // Note: "mark_" must be there instead of "wc"
        $bulk_actions['mark_order-received'] = 'Change status to Order Received';
        $bulk_actions['mark_payment-received'] = 'Change status to Payment Received';
        return $bulk_actions;
    }

// 3. Set Custom Order Status @ WooCommerce Checkout Process

// add_action( 'woocommerce_thankyou', 'bbloomer_thankyou_change_order_status' );

    function wc_es_thankyou_change_order_status($order_id){
        if (!$order_id) return;
        $order = wc_get_order($order_id);
        $order->update_status('order-received');
        $order->update_status('payment-received');
    }

    public function getQuoteList(){
        global $wpdb;
        $quote_table = $wpdb->prefix . 'innovs_wc_es_quote';
        $estimate_table = $wpdb->prefix . 'innovs_wc_es';
        $quote_details_table = $wpdb->prefix . 'innovs_product_quote_details';
        //$QuoteList = $wpdb->get_results("SELECT * FROM $quote_table");

        $QuoteList = $wpdb->get_results("SELECT q.id quote_id, qd.price, es.id estimate_id, q.id product_id, es.estimate_name,es.user_email,es.user_contact, sum(qd.total_price) total FROM `$estimate_table` es,`$quote_table` q, `$quote_details_table` qd WHERE q.estimate_id = es.id and es.id = q.estimate_id and qd.quote_id = q.id group by qd.quote_id");
        //print_r($QuoteList); die();
        return $QuoteList;
    }

}

?>