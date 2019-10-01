<?php
/**
 * 
 * 1. Register and enqueue script and styles
 * 2. Register templates CPT
 */



/**
 * 1. Register and enqueue script and styles
 */
    // De-register HTML5 Blank styles
    function sitecreator_styles_make_child_active()
    {
    wp_deregister_style('html5blank'); // Enqueue it!
    }
    add_action('wp_enqueue_scripts', 'sitecreator_styles_make_child_active', 100); // Add Theme Child Stylesheet

    // Load HTML5 Blank Child styles
    function sitecreator_styles_child()
    {
    // Register Child Styles
    wp_register_style('sitecreator-child', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_register_style('child-all', get_stylesheet_directory_uri() . '/css/all.css', array(), '1.0', 'all');

    // Enqueue Child Styles
    wp_enqueue_style('sitecreator-child'); 
    wp_enqueue_style('child-all');

    //Register Child Scripts
    //wp_register_script( 'bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );
    //wp_register_script( 'theme-script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ) );
    
    // Enqueue Child Scripts
    //wp_enqueue_script( 'bootstrap' ); 
    //wp_enqueue_script( 'theme-script' );   


}
add_action('wp_enqueue_scripts', 'sitecreator_styles_child', 20); // Add Theme Child Stylesheet


/**
 * 2. Register templates CPT
 */
register_post_type( 'templates',
array(
  'labels' => array(
    'name' => __( 'Templates' ),
    'singular_name' => __( 'Template' )
  ),
  'public' => true,  // it's not public, it shouldn't have it's own permalink, and so on
  'publicly_queryable' => true,  // you should be able to query it
  'show_ui' => true,  // you should be able to edit it in wp-admin
  'exclude_from_search' => false,  // you should exclude it from search results
  'show_in_nav_products' => false,  // you shouldn't be able to add it to products
  'has_archive' => false,  // it shouldn't have archive page
  'rewrite' => false,  // it shouldn't have rewrite rules
  //'taxonomies'  => array( 'item_type' , 'gender' ),
  'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields','excerpt' ),
)
);

$taxonomies = array(
  array(
      'slug'         => 'type',
      'single_name'  => 'Type',
      'plural_name'  => 'Types',
      'post_type'    => 'templates',
      'rewrite'      => array( 'slug' => 'type' ),
      'hierarchical' => true,
  )
);
foreach( $taxonomies as $taxonomy ) {
  $labels = array(
      'name' => $taxonomy['plural_name'],
      'singular_name' => $taxonomy['single_name'],
      'search_items' =>  'Search ' . $taxonomy['plural_name'],
      'all_items' => 'All ' . $taxonomy['plural_name'],
      'parent_item' => 'Parent ' . $taxonomy['single_name'],
      'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
      'edit_item' => 'Edit ' . $taxonomy['single_name'],
      'update_item' => 'Update ' . $taxonomy['single_name'],
      'add_new_item' => 'Add New ' . $taxonomy['single_name'],
      'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
      'menu_name' => $taxonomy['plural_name']
  );
  
  $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
  $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;

  register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
      'hierarchical' => $hierarchical,
      'labels' => $labels,
      'show_ui' => true,
      'query_var' => true,
      'rewrite' => $rewrite,
  ));
  }


/**
 * 2. Register templates CPT
 *
 * @link https://wpforms.com/developers/add-field-values-for-dropdown-checkboxes-and-multiple-choice-fields/
 *
 */
function sitecreator_wpf_dev_show_fields_options_setting() {
 
  return true;
}
add_action( 'wpforms_fields_show_options_setting', 'sitecreator_wpf_dev_show_fields_options_setting', 10, 2 );


add_post_type_support( 'post', 'page-attributes' );
?>