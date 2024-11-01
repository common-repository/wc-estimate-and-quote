<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    innovs_wc_es
 * @subpackage innovs_wc_es/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    innovs_wc_es
 * @subpackage innovs_wc_es/includes
 * @author     Your Name <email@example.com>
 */
class  wc_estimate {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WC_ES_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $innovs_wc_es    The string used to uniquely identify this plugin.
	 */
	protected $product_innovs_wc_es;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WC_ES_VERSION' ) ) {
			$this->version = WC_ES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->product_innovs_wc_es = 'wc-estimate-and-quote';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - innovs_wc_es_Loader. Orchestrates the hooks of the plugin.
	 * - innovs_wc_es_i18n. Defines internationalization functionality.
	 * - innovs_wc_es_Admin. Defines all hooks for the admin area.
	 * - innovs_wc_es_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-es-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-es-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-product-estimate-admin.php';

		/**
		 * The class responsible for defining Settings
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/estimate_settings.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-product-estimate-public.php';


		/**
		 * The class responsible for defining Page Templete
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/product-estimate-template.php';
		
		/**
		 * The class responsible for defining Page Templete
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-csv_export.php';

		/**
		 * The class responsible for defining Ajax
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-ajax.php';

		/**
		 * The class responsible for Pdf
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/lib/dompdf/vendor/autoload.php';
		 

	
		 /**
		  * The class responsible for CSV
		  * of the plugin.
		  */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/lib/PHPExcel/Classes/PHPExcel.php';
	 
		/**
		 * The class responsible for defining ShortCode
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/shortcode/estimate_list.php';

		$this->loader = new WC_ES_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the innovs_wc_es_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WC_ES_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WC_es_Admin( $this->get_product_innovs_wc_es(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wc_es_register_my_custom_menu_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_custome_fileld_admin_init' );
		//$this->loader->add_action( 'login_enqueue_scripts', $plugin_admin, 'wc_es_my_login_logo' );
		$this->loader->add_action( 'admin_footer_text', $plugin_admin, 'wc_es_demo_footer_filter' );
		$this->loader->add_action( 'woocommerce_login_redirect', $plugin_admin, 'wc_custom_user_redirect',10, 2 );
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'wc_es_remove_wp_logo',999 );
		$this->loader->add_action( 'woocommerce_register_shop_order_post_statuses', $plugin_admin, 'wc_es_register_custom_order_status',999 );
		$this->loader->add_action( 'wc_order_statuses', $plugin_admin, 'wc_es_show_custom_order_status',999 );
		$this->loader->add_action( 'bulk_actions-edit-shop_order', $plugin_admin, 'wc_es_get_custom_order_status_bulk',999 );
		$this->loader->add_action( 'woocommerce_thankyou', $plugin_admin, 'wc_es_thankyou_change_order_status',999 );
 
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WC_es_Public( $this->get_product_innovs_wc_es(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'product_list', $plugin_public, 'get_product_list' );
		$this->loader->add_action( 'sensore_list', $plugin_public, 'get_sensore_list' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'baseUrl' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'pluginUrl' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'wc_es_user_nav_visibility' );
		$this->loader->add_action( 'admin_init', $plugin_public, 'wc_es_redirect_users_by_role' );
		$this->loader->add_action( 'init', $plugin_public, 'wc_es_csv' );

 	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_product_innovs_wc_es() {
		return $this->product_innovs_wc_es;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WC_ES_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
?>