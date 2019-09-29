<?php


/* Content Width
-------------------------------------------------------- */

if ( ! isset( $content_width ) ) {

    $content_width = 1400;

}



/* Custom Excerpt
-------------------------------------------------------- */

if( ! function_exists( 'heythere_lite_custom_excerpt_length' ) ) {

    function heythere_lite_custom_excerpt_length( $length ) {
        if ( is_admin() ) {
            return $length;
        }
        return 40;
    }

    add_filter( 'excerpt_length', 'heythere_lite_custom_excerpt_length', 999 );

}

if( ! function_exists( 'heythere_lite_custom_excerpt_more' ) ) {

    function heythere_lite_custom_excerpt_more( $more ) {
        if ( is_admin() ) {
            return $more;
        }
        return ' ... ';
    }

    add_filter( 'excerpt_more', 'heythere_lite_custom_excerpt_more' );

}



/* Setup Theme
-------------------------------------------------------- */

if( ! function_exists( 'heythere_lite_setup_theme' ) ) {

    function heythere_lite_setup_theme() {
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo');
        add_image_size('heythere_lite_big', 1400, 800, true);
        register_nav_menus(array(
            'main-menu' => esc_html__( 'Main Menu', 'heythere-lite' ),
            'all-projects-link' => esc_html__( 'All Projects Link', 'heythere-lite' ),
            'social-menu' => esc_html__( 'Social Menu', 'heythere-lite' )
        ));
        load_theme_textdomain('heythere-lite', get_template_directory().'/languages');
    }

}

add_action( 'after_setup_theme', 'heythere_lite_setup_theme' );



/* Register Sidebar
-------------------------------------------------------- */

if( ! function_exists( 'heythere_lite_sidebars' ) ) {

    function heythere_lite_sidebars() {
        register_sidebar(array(
            'name' => esc_html__( 'Main Sidebar', 'heythere-lite' ),
            'id' => 'main-sidebar',
            'description' => esc_html__( 'Main Sidebar', 'heythere-lite' ),
            'before_title' => '<h3>',
            'after_title' => '</h3>',
            'before_widget' => '<div>',
            'after_widget' => '</div>'
        ));
    }

}

add_action( 'widgets_init', 'heythere_lite_sidebars' );



/* Include Css Files
-------------------------------------------------------- */

if(! function_exists( 'heythere_lite_styles' ) ) {

    function heythere_lite_styles(){
        wp_enqueue_style('heythere-lite-style-default-css', get_template_directory_uri() .'/style.css');
        wp_enqueue_style('heythere-lite-font-roboto-condensed', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700');
        wp_enqueue_style('heythere-lite-font-roboto', '//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900');
        wp_enqueue_style('heythere-lite-font-awesome', get_template_directory_uri() .'/font-awesome/css/font-awesome.css');
    }

}

add_action( 'wp_enqueue_scripts', 'heythere_lite_styles' );



/* Include Javascript Files
-------------------------------------------------------- */
if(! function_exists( 'heythere_lite_scripts' ) ) {

    function heythere_lite_scripts() {
        wp_enqueue_script('heythere-lite-fullpage-plugin', get_template_directory_uri() .'/js/jquery.fullpage.js', array('jquery'), null, true);
        wp_enqueue_script('heythere-lite-script-js', get_template_directory_uri() .'/js/script.js', array('jquery'), null, true);
        if ( is_singular() ) wp_enqueue_script( "comment-reply" );
    }

}

add_action( 'wp_enqueue_scripts', 'heythere_lite_scripts' );



/* Include the TGM_Plugin_Activation class.
-------------------------------------------------------- */

require_once dirname( __FILE__ ) . '/functions/class-tgm-plugin-activation.php';

if(! function_exists( 'heythere_lite_register_recommended_plugins' ) ) {

    function heythere_lite_register_recommended_plugins() {
    	$plugins = array(
    		array(
    			'name'     => 'Projects Postype',
    			'slug'     => 'projects-postype',
                'source'   => '',
    			'required' => false,
    		)
    	);
    	tgmpa( $plugins );
    }

}

add_action( 'tgmpa_register', 'heythere_lite_register_recommended_plugins' );



/* Custom Logos
-------------------------------------------------------- */

if( ! function_exists( 'heythere_lite_custom_logo_uploader' ) ) {

    function heythere_lite_custom_logo_uploader( $wp_customize ) {

        function heythere_lite_sanitize_file( $file, $setting ) {
            $mimes = array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'gif'          => 'image/gif',
                'png'          => 'image/png'
            );
            $file_ext = wp_check_filetype( $file, $mimes );
            return ( $file_ext['ext'] ? $file : $setting->default );
        }

        $wp_customize->add_setting( 'custom_logo', array(
            'default'        => '',
            'sanitize_callback' => 'heythere_lite_sanitize_file'
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo', array(
            'label'   => 'Light Logo',
            'section' => 'title_tagline',
            'settings'   => 'custom_logo',
            'priority' => 1
        ) ) );
        $wp_customize->add_setting( 'custom_logo_2', array(
            'default'        => '',
            'sanitize_callback' => 'heythere_lite_sanitize_file'
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo_2', array(
            'label'   => 'Dark Logo',
            'section' => 'title_tagline',
            'settings'   => 'custom_logo_2',
            'priority' => 2
        ) ) );

    }

}

add_action( 'customize_register', 'heythere_lite_custom_logo_uploader' );


?>
