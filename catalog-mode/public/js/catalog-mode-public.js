(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
		function removePrice() {
        // Use jQuery to remove elements with the class "rpress-price-holder"
        $(".price").remove();
		}
        
		 // Function to remove elements
		function removeElements() {
		$(".rpress_fooditem_buy_button").remove();
		$(".rpress-sidebar-cart-wrap").remove();
		$(".rpress-category-lists").remove();
		$(".rpress_fooditems_list").removeClass("rp-col-lg-6").addClass("rp-col-lg-12");
	 }
		
		// Function to check catalog mode status and then remove elements
		function checkAndRemoveElements() {
			$.ajax({
				type: 'POST',
				url: catalogmode.ajaxurl, // WordPress AJAX URL
				data: {
					action: 'check_catalog_mode_status'
				}, 
				success: function(response) {
					if (response.catalog_mode === 'catalog_mode_enabled') {						
						removeElements();
					}
					if (response.price_enable === 'price_enable') {

					}
					else{
						removePrice();
					}
				}
				
			});
		}
		// When the "Grid View" button is clicked
		$('#grid-view-btn').on('click', function() {
			$('.rpress_fooditems_list').removeClass('rpress-list').addClass('rpress-grid');
			// You can also save the selected view option in a cookie or localStorage here.
		});
	
		// When the "List View" button is clicked
		$('#list-view-btn').on('click', function() {
			$('.rpress_fooditems_list').removeClass('rpress-grid').addClass('rpress-list');
			// You can also save the selected view option in a cookie or localStorage here.
		});
	
		// DOM-ready handler
		$( window ).load(function() {
			// Check catalog mode status and remove elements accordingly
			checkAndRemoveElements();
		});
	
})( jQuery );
