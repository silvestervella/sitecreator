<?php
/**
 * 
 * 1. Register and enqueue script and styles
 * 2. Add theme and post type support
 * 3. Add custom logo + check for svg
 * 4. Add top section background selector in customizer
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

?>