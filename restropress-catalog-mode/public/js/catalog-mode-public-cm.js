// JavaScript code
jQuery(document).ready(function($) {
    // Initially hide the elements related to catalog mode
    $('.rpress_fooditem_buy_button, .rpress-sidebar-cart-wrap, .rpress-category-lists, .rp-col-lg-6, .rpress_purchase_submit_wrapper').hide();

    // Toggle between catalog mode and normal mode
    $('#catalog-mode-toggle').on('click', function() {
        if ($(this).is(':checked')) {
            // Enable catalog mode
            $('.rpress_fooditem_buy_button, .rpress-sidebar-cart-wrap, .rpress-category-lists, .rp-col-lg-6, .rpress_purchase_submit_wrapper').hide();
        } else {
            // Disable catalog mode
            $('.rpress_fooditem_buy_button, .rpress-sidebar-cart-wrap, .rpress-category-lists, .rp-col-lg-6, .rpress_purchase_submit_wrapper').show();
        }
    });
});
