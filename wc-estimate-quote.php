<?php
    /**
     * The plugin bootstrap file
     *
     * This file is read by WordPress to generate the plugin information in the plugin
     * admin area. This file also includes all of the dependencies used by the plugin,
     * registers the activation and deactivation functions, and defines a function
     * that starts the plugin.
     *
     * @link              https://theinnovs.com
     * @since             1.0.0
     * @package           WC_ES_VERSION
     *
     * @wordpress-plugin
     * Plugin Name:       WooCommerce Estimate and Quote
     * Plugin URI:        http://wordpress.org/plugins/wc-estimate-and-quote
     * Description:       Live Product Cost Estimation, ask for Quotes, convert Estimates to Cart, print or email from the same place!
     * Version:           1.0.2.5
     * Author:            TheInnovs
     * Author URI:        https://theinnovs.com
     * License:           GPL-2.0+
     * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
     * Text Domain:       wc-estimate-and-quote
     * Domain Path:       /languages
     */

    // If this file is called directly, abort.
    if (!defined('WPINC')) {
        die;
    }

    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    define('WC_ES_VERSION', '1.0.2.5');

    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-plugin-name-activator.php
     */
    function activate_innovs_wc_es(){
        require_once plugin_dir_path(__FILE__) . 'includes/class-wc-es-activator.php';
        WC_ES_Activator::activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-plugin-name-deactivator.php
     */
    function deactivate_innovs_wc_es(){
        require_once plugin_dir_path(__FILE__) . 'includes/class-wc-es-deactivator.php';
        WC_ES_Deactivator::deactivate();
    }

    register_activation_hook(__FILE__, 'activate_innovs_wc_es');
    register_deactivation_hook(__FILE__, 'deactivate_innovs_wc_es');


    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path(__FILE__) . 'includes/class-wc-es.php';

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function wc_es_product_estimate(){
        $plugin = new wc_estimate();
        $plugin->run();
    }

    wc_es_product_estimate();
?>