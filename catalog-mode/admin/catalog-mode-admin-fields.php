<?php
/**
 * Catalog_Mode_Settings
 *
 * @package Catalog_Mode_Settings
 * @since 1.0
 */

 defined( 'ABSPATH' ) || exit;


$catalog_settings          = new Catalog_Mode_Admin();
$catalog_settings          = $catalog_settings->options;



$all_terms = array(); // Your code to retrieve food item categories goes here

if (is_array($all_terms) && !empty($all_terms)) :
  foreach ($all_terms as $term_slug) :
      $prepared_query = RP_Shortcode_Fooditems::query($term_slug);
      $atts = RP_Shortcode_Fooditems::$atts;

      // Allow the query to be manipulated by other plugins
      $query = add_filter('rpress_fooditems_query', $prepared_query, $atts);

      $fooditems = new WP_Query($query);

      if ($fooditems->have_posts()) :
          $i = 1;

          while ($fooditems->have_posts()) : $fooditems->the_post();
              $id = get_the_ID();
              $food_item_title = get_the_title();
              $food_item_link = get_permalink(); // Get the link to the food item detail page
              ?>
              <div class="rpress_fooditem">
                  <h2><?php echo $food_item_title; ?></h2>
                  <p><a href="<?php echo $food_item_link; ?>">View Details</a></p>
              </div>
              <?php
              $i++;
          endwhile;

          wp_reset_postdata();
      endif;
  endforeach;
else :
  /* translators: %s: post singular name */
  printf(_x('No %s found', 'rpress post type name', 'restropress'), rp_get_label_plural());
endif;
?>
