<?php

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
		add_filter( 'body_class', array($this,'add_catalog_mode_body_class' ));
			
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
		$section['catalog_mode_settings'] = __( 'Catalog Mode', 'rpress-catalog-mode' );
		return $section;
	  }
	// Setting section
	  public function catalog_mode_settings_fields( $general_settings ) {
	
		$general_settings['catalog_mode_settings']['catalog_mode_heading'] = array(
			'id'            => 'catalog_mode_settings_heading',
			'class'         => 'catalog_mode_settings_heading',
			'name'          => '<h3>' . __( 'Catalog Mode', 'rpress-catalog-mode' ) . '</h3>',
			'desc'          => '',
			'type'          => 'header',
			'tooltip_title' => __( 'Catalog Mode Setting', 'rpress-catalog-mode' ),
		);
	
		$general_settings['catalog_mode_settings']['catalog_mode_enable'] = array(
			'id'    => 'catalog_mode_enable',
			'name'  => __( 'Enable Catalog Mode', 'rpress-catalog-mode' ),
			'desc'  => __( 'Enable Catalog Mode', 'rpress-catalog-mode' ),
			'type'  => 'checkbox',
		);
		$general_settings['catalog_mode_settings']['price_enable'] = array(
			'id'    => 'price_enable',
			'name'  => __( 'Enable Price', 'rpress-catalog-mode' ),
			'desc'  => __( 'Enable Price', 'rpress-catalog-mode' ),
			'type'  => 'checkbox',
		);
		
        
		$general_settings['catalog_mode_settings']['option_view_food_items'] = array(
			'id'            => 'option_view_food_items',
			'type'          => 'radio',
			'desc'          => __( 'For Use Of List View And Grid View Option ', 'rpress-catalog-mode' ),
			'options' 		=> array(
				'list_view'  => __( 'List View', 'rpress-catalog-mode' ),
				'grid_view'  => __( 'Grid View', 'rpress-catalog-mode' ),
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
			return '<span class="rpress_empty_cart">' . __( 'Choose an item from the menu to get started.', 'rpress-catalog-mode' ) . '</span>';
		}
	}
	public function remove_add_to_cart_button($label) {
		if( rpress_get_option('catalog_mode_enable') == 1 ) {
			return ''; // Return an empty string to remove the "Add" button label
		}else {
			return '<span class="add_to_cart_button">' . __( 'Add', 'rpress-catalog-mode' ) . '</span>';
		}

	}
	public function remove_rpress_cart_title($title) {
		if( rpress_get_option('catalog_mode_enable') == 1 ) {
		return ''; // Return an empty string to remove the title unconditionally
	}
	else {
		return '<span class="rpress_cart_title">' . __( 'Your Order', 'rpress-catalog-mode' ) . '</span>';
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

public function add_catalog_mode_body_class($classes) {
    // Check if catalog mode is enabled (you need to replace this condition with your actual logic)
    if (1 == rpress_get_option('catalog_mode_enable')) {
        // Add 'catalog-mode-enabled' class to the body classes array
        $classes[] = 'catalog-mode-enabled';
    }
	    // Check if catalog mode is enabled (you need to replace this condition with your actual logic)
		if (1 == rpress_get_option('price_enable')) {
			// Add 'catalog-mode-enabled' class to the body classes array
			$classes[] = 'price-enabled';
		}

    return $classes;
}


}
