<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://author.example.com/
 * @since      1.0.0
 *
 * @package    Catalog_Mode
 * @subpackage Catalog_Mode/includes
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
 * @package    Catalog_Mode
 * @subpackage Catalog_Mode/includes
 * @author     Rajalaxmi <rajalaxmi7787@gmail.com>
 */
class Catalog_Mode {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Catalog_Mode_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

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
		if ( defined( 'CATALOG_MODE_VERSION' ) ) {
			$this->version = CATALOG_MODE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'catalog-mode';

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
	 * - Catalog_Mode_Loader. Orchestrates the hooks of the plugin.
	 * - Catalog_Mode_i18n. Defines internationalization functionality.
	 * - Catalog_Mode_Admin. Defines all hooks for the admin area.
	 * - Catalog_Mode_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-catalog-mode-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-catalog-mode-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-catalog-mode-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-catalog-mode-public.php';

		$this->loader = new Catalog_Mode_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Catalog_Mode_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Catalog_Mode_i18n();

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

		$plugin_admin = new Catalog_Mode_Admin( $this->get_plugin_name(), $this->get_version() );
		
			//$catalog_mode_enabled = rpress_get_option('catalog_mode_enable');
			//print_r($catalog_mode_enabled);
			
			// if( $catalog_mode_enabled == 1 ){
				
				//add_filter( 'rpress_show_added_to_cart_messages', array( $this, 'remove_cart' ) );
				// $this->loader->add_action( 'rpress_after_fooditem_content', 'rpress_show_added_to_cart_messages' ) ;
				// $this->loader->add_filter('rpress_empty_cart_message','remove_empty_cart_message');
				// $this->loader->add_filter('rpress_add_to_cart_text','remove_add_to_cart_button');
				// $this->loader->add_filter('rpress_cart_title','remove_rpress_cart_title');
				// $this->loader->add_filter('rpress_fooditem_content','remove_fooditem_content', 10, 3);
				// $this->loader->add_filter('rp_confirm_order_text', 'remove_rp_confirm_order_text');
				// $this->loader->add_filter('rpress_fooditem_price','remove_fooditem_price', 10, 2);
				// $this->loader->add_filter('rpress_show_checkout_button','custom_remove_cart_and_checkout_button');
				//Add the custom action hook handler
				// $this->loader->add_action('init','custom_remove_category_list');

				// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
				// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
				// $this->loader->add_filter( 'rpress_settings_sections_general',$plugin_admin, 'add_catalog_mode_setting_section'  );
				// $this->loader->add_filter( 'rpress_settings_general',$plugin_admin, 'catalog_mode_settings_fields' , 10, 1 );
			// }

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Catalog_Mode_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


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
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Catalog_Mode_Loader    Orchestrates the hooks of the plugin.
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
