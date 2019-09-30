<?php
/*
Plugin Name: Sitecreator Theme - Quotation creator
Plugin URI: https://mygreyblack.com/
Description: Create an instant quotation
Author: ..
Version: 1.0
*/

defined( 'ABSPATH' ) or die( 'Oops!' );

global $wp_rewrite;


add_action( 'wpcf7_init', 'sitecreator_wpcf7_add_form_tag' );
 
function sitecreator_wpcf7_add_form_tag() {
    wpcf7_add_form_tag(
        array( 'templates*'),
        'sitecreator_cf7addTemplates', array( 'name-attr' => true ) );
}

function sitecreator_cf7addTemplates() {
    $templatesField = '';
    $templates = get_posts(array(
        'post_type' => 'templates'
    ));

    if ($templates):
        $templatesField = '<div">';
        ?>

        <?php
        foreach($templates as $template) {
            $templatesField .= '<label>
                                <input type="radio" name="test" value="small" >
                                <img src="'. get_the_post_thumbnail_url( $template->ID  ) .'">
                                </label>';
        }
        $templatesField .= "</div>";
    endif;

    return $templatesField;
}
?>