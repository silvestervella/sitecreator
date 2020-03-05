<?php 
add_action( 'wp_enqueue_scripts', 'arlo_fn_enqueue_styles' );
function arlo_fn_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

/**
 * 
 * 1. Register and enqueue script and styles
 * 2. Register templates CPT
 * 3. Add page attributes to posts
 * 4. Check/add term (Site feature ID) to Preview cpt Template taxonomy
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
    wp_register_style('child-all', get_stylesheet_directory_uri() . '/css/all.css', array(), '1.0', 'all');
    // Child all.css
    wp_enqueue_style('child-all');



    //Register Child Scripts
    wp_register_script( 'theme-script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ) );
    // Enqueue Child Scripts
    wp_enqueue_script( 'theme-script' );   
}
add_action('wp_enqueue_scripts', 'sitecreator_styles_child', 20); // Add Theme Child Stylesheet





/**
 * 2. Register templates CPT
 */
register_post_type( 'site-features',
array(
  'labels' => array(
    'name' => __( 'Site Features' ),
    'singular_name' => __( 'Feature' ),
  ),
  'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
  'publicly_queryable' => true,  // you should be able to query it
  'show_ui' => true,  // you should be able to edit it in wp-admin
  'exclude_from_search' => false,  // you should exclude it from search results
  'show_in_nav_products' => false,  // you shouldn't be able to add it to products
  'has_archive' => false,  // it shouldn't have archive page
  'rewrite' => false,  // it shouldn't have rewrite rules
  'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields','excerpt' )
)
);

register_post_type( 'orders',
array(
  'labels' => array(
    'name' => __( 'Orders' ),
    'singular_name' => __( 'Order' )
  ),
  'public' => true,  // it's not public, it shouldn't have it's own permalink, and so on
  'publicly_queryable' => true,  // you should be able to query it
  'show_ui' => true,  // you should be able to edit it in wp-admin
  'exclude_from_search' => true,  // you should exclude it from search results
  'show_in_nav_products' => false,  // you shouldn't be able to add it to products
  'has_archive' => false,  // it shouldn't have archive page
  'rewrite' => false,  // it shouldn't have rewrite rules
  //'taxonomies'  => array( 'item_type' , 'gender' ),
  'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields','excerpt' )
)
);

register_post_type( 'previews',
array(
  'labels' => array(
    'name' => __( 'Previews' ),
    'singular_name' => __( 'Preview' )
  ),
  'public' => true,  // it's not public, it shouldn't have it's own permalink, and so on
  'publicly_queryable' => true,  // you should be able to query it
  'show_ui' => true,  // you should be able to edit it in wp-admin
  'exclude_from_search' => true,  // you should exclude it from search results
  'show_in_nav_products' => false,  // you shouldn't be able to add it to products
  'has_archive' => false,  // it shouldn't have archive page
  'rewrite' => false,  // it shouldn't have rewrite rules
  //'taxonomies'  => array( 'item_type' , 'gender' ),
  'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields','excerpt' )
)
);

$taxonomies = array(
  array(
      'slug'         => 'type',
      'single_name'  => 'Type',
      'plural_name'  => 'Types',
      'post_type'    => 'site-features',
      'rewrite'      => array( 'slug' => 'type' ),
      'hierarchical' => true,
  ),
  array(
    'slug'         => 'template',
    'single_name'  => 'Template',
    'plural_name'  => 'Templates',
    'post_type'    => 'previews',
    'rewrite'      => array( 'slug' => 'previews' ),
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
      'public' => false,  
      'show_admin_column' => true
  ));
  }


/**
 * 3. Add page attributes to posts
*/
add_post_type_support( 'post', 'page-attributes' );


/**
 * 4. Check/add term (Site feature ID) to Preview cpt Template taxonomy
*/
$args = array(
  'post_type' => 'site-features',
  'posts_per_page'=>-1, 
  'numberposts'=>-1,
  'tax_query' => array(
      array(
          'taxonomy' => 'type',
          'field' => 'slug',
          'terms' => 'templates',
      )
  )
); 
$theme_posts = get_posts($args);

if ($theme_posts) {
  foreach($theme_posts as $theme_post) { 
    if (!term_exists('ID - '.$theme_post->ID ,  'template')) {
      wp_insert_term( 'ID - '.$theme_post->ID, 'template');
    }
  }
}





add_filter('manage_edit-site-features_columns', 'posts_columns_id', 5);
add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);

function posts_columns_id($defaults){
$defaults['wps_post_id'] = __('ID');
return $defaults;
}
function posts_custom_id_columns($column_name, $id){
if($column_name === 'wps_post_id'){
        echo $id;
}
}
  



?>