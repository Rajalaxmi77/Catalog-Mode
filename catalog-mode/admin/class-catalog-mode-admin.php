<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://author.example.com/
 * @since      1.0.0
 *
 * @package    Catalog_Mode
 * @subpackage Catalog_Mode/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Catalog_Mode
 * @subpackage Catalog_Mode/admin
 * @author     Rajalaxmi <rajalaxmi7787@gmail.com>
 */
class Catalog_Mode_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		 add_filter( 'rpress_settings_sections_general', array( $this, 'add_catalog_mode_setting_section' ) );
		add_filter( 'rpress_settings_general', array( $this, 'catalog_mode_settings_fields' ), 10, 1 );
		
		add_action("init", [$this, 'init_cb']);

	}
	public function init_cb() {
			
			add_action( 'rpress_after_fooditem_content', array( $this, 'rpress_show_added_to_cart_messages' ) );
			add_filter('rpress_empty_cart_message',array($this, 'remove_empty_cart_message'));
			add_filter('rpress_add_to_cart_text',array($this, 'remove_add_to_cart_button'));//remove Add button
			add_filter('rpress_cart_title',array($this, 'remove_rpress_cart_title'));//Remove Your Order
			add_action('init',array($this, 'custom_remove_category_list'));
			add_action('wp_ajax_check_catalog_mode_status', array( $this, 'check_catalog_mode_status'));
			add_action('wp_ajax_nopriv_check_catalog_mode_status', array( $this, 'check_catalog_mode_status'));
		
	}
	

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Catalog_Mode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Catalog_Mode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( _FILE_ ) . 'css/catalog-mode-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Catalog_Mode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Catalog_Mode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( _FILE_ ) . 'public/js/catalog-mode-public.js', array( 'jquery' ), $this->version, false );

	}	
	
	public function add_catalog_mode_setting_section( $section ) {
		$section['catalog_mode_settings'] = __( 'Catalog Mode', 'rpress-catalog' );
		return $section;
	  }
	// Setting section
	  public function catalog_mode_settings_fields( $general_settings ) {
	
		$general_settings['catalog_mode_settings']['catalog_mode_heading'] = array(
			'id'            => 'catalog_mode_settings_heading',
			'class'         => 'catalog_mode_settings_heading',
			'name'          => '<h3>' . __( 'Catalog Mode', 'rpress-catalog' ) . '</h3>',
			'desc'          => '',
			'type'          => 'header',
			'tooltip_title' => __( 'Catalog Mode Setting', 'rpress-catalog' ),
		);
	
		$general_settings['catalog_mode_settings']['catalog_mode_enable'] = array(
			'id'    => 'catalog_mode_enable',
			'name'  => __( 'Enable Catalog Mode', 'rpress-catalog' ),
			'desc'  => __( 'Enable Catalog Mode', 'rpress-catalog' ),
			'type'  => 'checkbox',
		);
		$general_settings['catalog_mode_settings']['price_enable'] = array(
			'id'    => 'price_enable',
			'name'  => __( 'Enable Price', 'rpress-catalog' ),
			'desc'  => __( 'Enable Price', 'rpress-catalog' ),
			'type'  => 'checkbox',
		);
		
        
		$general_settings['catalog_mode_settings']['option_view_food_items'] = array(
			'id'            => 'option_view_food_items',
			'type'          => 'radio',
			'desc'          => __( 'For Use Of List View And Grid View Option ', 'restropress' ),
			'options' 		=> array(
				'list_view'  => __( 'List View', 'rpress-catalog' ),
				'grid_view'  => __( 'Grid View', 'rpress-catalog' ),
			),
			'std' => 'list_view',
		);
	
		return $general_settings;
	
		}

		

	// Function to enable catalog mode
	public function enable_catalog_mode() {
        remove_action('restropress_before_cart', 'rp_cart_widget');
        remove_action('restropress_cart', 'rp_cart');
        remove_action('restropress_checkout', 'rp_checkout');
        remove_action('restropress_after_checkout', 'rp_thank_you');
    }

    // Function to disable catalog mode
    public function disable_catalog_mode() {
        add_action('restropress_before_cart', 'rp_cart_widget');
        add_action('restropress_cart', 'rp_cart');
        add_action('restropress_checkout', 'rp_checkout');
        add_action('restropress_after_checkout', 'rp_thank_you');
    }
               

	public function remove_empty_cart_message() {
		if( rpress_get_option('catalog_mode_enable') == 1 ) {
			return ''; // Return an empty string to remove the message
		} else {
			return '<span class="rpress_empty_cart">' . __( 'Choose an item from the menu to get started.', 'restropress' ) . '</span>';
		}
	}
	public function remove_add_to_cart_button($label) {
		if( rpress_get_option('catalog_mode_enable') == 1 ) {
			return ''; // Return an empty string to remove the "Add" button label
		}else {
			return '<span class="add_to_cart_button">' . __( 'Add', 'restropress' ) . '</span>';
		}

	}
	public function remove_rpress_cart_title($title) {
		if( rpress_get_option('catalog_mode_enable') == 1 ) {
		return ''; // Return an empty string to remove the title unconditionally
	}
	else {
		return '<span class="rpress_cart_title">' . __( 'Your Order', 'restropress' ) . '</span>';
	}
	}
	
	public function remove_rp_confirm_order_text() {
		if( rpress_get_option('catalog_mode_enable') == 1 ) {
			return ''; // Return an empty string to remove the text
		}
	}
	
	public function remove_fooditem_price($price, $fooditem_id) {
        return ''; // Return an empty string to remove the price display
    }
	/**
 * Remove the cart and checkout button using the rpress_show_checkout_button hook.
 */
	public function custom_remove_cart_and_checkout_button($show_checkout_button) {
    
     // To always remove the button, set $show_checkout_button to false.
    $show_checkout_button = false;

    return $show_checkout_button;
}
// Define a custom action hook handler to remove the default action
public function custom_remove_category_list() {
	if ( $data['category_menu'] ) {
		$get_all_items = rpress_get_child_cats( $data['ids'] );
	  } else {
		$get_all_items = rpress_get_categories( $data );
	  }
	  $disable_category = rpress_get_option( 'disable_category_menu', true );
    remove_action('rpress_after_category_list', 'default_category_list_function'); // Replace 'default_category_list_function' with the actual function name used in the plugin
}
public function check_catalog_mode_status() {
	$response = array();
    if (rpress_get_option('catalog_mode_enable') == 1) {
        $response['catalog_mode'] = 'catalog_mode_enabled';
    } else {
        $response['catalog_mode'] = 'catalog_mode_disabled';
    }
	if (rpress_get_option('price_enable') == 1) {
        $response['price_enable'] = 'price_enable';
    } else {
        $response['price_enable'] = 'price_disable';
    }
	wp_send_json($response);
    die();
}
public function rpress_show_food_items() {
    $option_view_food_items = rpress_get_option('option_view_food_items');

    if ($option_view_food_items == "grid_view") {
        $food_item_class = "rpress-grid";
    } else {
        $food_item_class = "rpress-list";
    }

    // Now, you can use the $food_item_class in your HTML or PHP code to apply the appropriate class to your food items container.
    
    echo '<div class="rpress_fooditems_list ' . $food_item_class . '">';
    
    echo '</div>';
}

}
