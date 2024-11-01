<?php
/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    product_estimate
 * @subpackage product_estimate/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    product_estimate
 * @subpackage product_estimate/includes
 * @author     Your Name <email@example.com>
 */
class WC_ES_Deactivator{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate(){
        global $wpdb;
        $estimate = $wpdb->prefix . 'wc_es';
        $estimate_products = $wpdb->prefix . 'wc_es_products';
        self::user_remove_role();
    }

    private static function user_remove_role(){
        remove_role('Estimate-admin');
        remove_role('product-manager');
        remove_role('order-manager');
        remove_role('normal-user');
    }

}
?>