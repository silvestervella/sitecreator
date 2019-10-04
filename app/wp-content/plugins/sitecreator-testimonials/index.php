<?php
/*
Plugin Name: Sitecreator Theme - Testimonials
Plugin URI: https://mygreyblack.com/
Description: Testimonial generator plugin
Author: ..
Version: 1.0
*/

define( 'sitecreator_testimonials', '1.0.0' );

defined( 'ABSPATH' ) or die( 'Oops!' );

global $wp_rewrite;

function sitecreator_testimonials() {

// create post type
register_post_type( 'testimonials',
array(
  'labels' => array(
    'name' => __( 'Testimonials' ),
    'singular_name' => __( 'Testimonial' )
  ),
  'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
  'publicly_queryable' => true,  // you should be able to query it
  'show_ui' => true,  // you should be able to edit it in wp-admin
  'exclude_from_search' => false,  // you should exclude it from search results
  'show_in_nav_products' => false,  // you shouldn't be able to add it to products
  'has_archive' => false,  // it shouldn't have archive page
  'rewrite' => false,  // it shouldn't have rewrite rules
  //'taxonomies'  => array( 'item_type' , 'gender' ),
  'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields','excerpt' )
)
);


function sitecreator_get_testimonials() {

  $field = '';
  $testimonials = get_posts(array(
      'post_type' => 'testimonials',
  ));
  if ($testimonials):
      $section = '<div>';
      foreach($testimonials as $testimonial) {
          $section .= '<label>
                          <input type="radio" class="calc" name="" value="' . $testimonial->post_name . '">
                          <img src="'. get_the_post_thumbnail_url( $testimonial->ID  ) .'">
                      </label>';
      }
      $section .= '</div>';
  endif; 
return $section;
}

add_shortcode( 'get_testimonials', 'sitecreator_get_testimonials' );

}

add_action('init', 'sitecreator_testimonials'); 
?>