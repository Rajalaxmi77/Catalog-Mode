jQuery(document).ready(function($) {
    // Check if the body tag has the 'catalog-mode-enabled' class
    if ($('body').hasClass('catalog-mode-enabled')) {
        // Remove and hide elements when catalog mode is enabled
		$('.rpress_fooditems_list').removeClass('rp-col-lg-6').addClass('rp-col-lg-12');
        $('.rpress_fooditems_list').removeClass('rp-col-lg-8').addClass('rp-col-lg-12');
    }
	if (!$('body').hasClass('price-enabled')) {
        // Remove and hide elements when catalog mode is enabled
       $('.price').remove();
    }
	
});
