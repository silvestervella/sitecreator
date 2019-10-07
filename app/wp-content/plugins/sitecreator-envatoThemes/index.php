<?php
/*
Plugin Name: SiteCreator Theme - Envato Themes
Plugin URI: https://sitecreator.com/
Description: Get Envato themes data
Author: ..
Version: 1.0
*/

// Add menu page
add_action('admin_menu', 'sitecreator_envato_setup_menu');
function sitecreator_envato_setup_menu(){
        add_menu_page( 'Get Envato Themes', 'Get Envato Themes', 'manage_options', 'get-envato-plugin', 'sitecreator_envato_init' );
}
 
function sitecreator_envato_init(){

    // General check for user permissions.
    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have permission to access this page.')    );
    }
    echo "<h1>Get Envato Themes</h1>";

  // Check whether the button has been pressed AND also check the nonce
  if (isset($_POST['envatothemes_button']) && check_admin_referer('envatothemes_button_clicked')) {
    // the button has been pressed AND we've passed the security check
    sitecreator_get_envato_themes();
  }

    // Check whether the button has been pressed AND also check the nonce
    if (isset($_POST['envatothemes_getcollections']) && check_admin_referer('envatothemes_getcollections_clicked')) {
      // the button has been pressed AND we've passed the security check
      sitecreator_get_envato_collections();
    }

  echo '<form action="'. admin_url("admin.php?page=get-envato-plugin") .'" method="post">';

  // this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
  wp_nonce_field('envatothemes_button_clicked');
  echo '<input type="hidden" value="true" name="envatothemes_button" />';
  echo 'Get themes';
  submit_button('Call Function');
  echo '</form>';
  echo '</div>';


  echo '<form action="'. admin_url("admin.php?page=get-envato-plugin") .'" method="post">';

  // this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
  wp_nonce_field('envatothemes_getcollections_clicked');
  echo '<input type="hidden" value="true" name="envatothemes_getcollections" />';
  echo 'Get collections';
  submit_button('Call Function');
  echo '</form>';
  echo '</div>';

}


function sitecreator_get_envato_themes($atts) {
  $url = "https://api.envato.com/v3/market/user/collection?id=" . $atts['collection_id'];
  $curl = curl_init($url);
  
  $personal_token = "";
  $header = array();
  $header[] = 'Authorization: Bearer '.$personal_token;
  $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
  $header[] = 'timeout: 20';
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
  
  $envatoRes = curl_exec($curl);
  curl_close($curl);
  $envatoRes = json_decode($envatoRes);

  $items = $envatoRes->items;

  foreach ($items as $item) {

    $theme_post_id = $item->id;
    $theme_post_name = $item->name;

    $theme_post = array(
      //'ID'            => '345678',
      'post_title'    => $item->name,
      'post_content'  => 'contenttt',
      'post_status'   => 'publish',
      'post_type'     => 'site-features',
      'post_name'     => $theme_post_id
    );

      $args = array(
        'post_type' => 'site-features',
        'name'  =>  $theme_post_id,
        'suppress_filters' => false
    ); 
    $theme_posts = get_posts($args);

    if (!$theme_posts) {

      wp_insert_post( $theme_post );
      $the_post_slug = get_page_by_title( $item->name , OBJECT, 'site-features');
      $the_post_id = $the_post_slug->ID;
      wp_set_object_terms( $the_post_id, 'templates' , 'type' );
      
      } else {
      return;
    }
  }
}

function  sitecreator_get_envato_collections() {
  $url = "https://api.envato.com/v3/market/user/collections";
  $curl = curl_init($url);
  
  $personal_token = "ry8dHahFRPPKpRh804AXWvmvo5z7xCXa";
  $header = array();
  $header[] = 'Authorization: Bearer '.$personal_token;
  $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
  $header[] = 'timeout: 20';
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
  
  $envatoRes = curl_exec($curl);
  curl_close($curl);
  $envatoRes = json_decode($envatoRes);

  $collections = $envatoRes->collections;

  foreach($collections as $collection) {
    // sitecreator_get_envato_themes(array(
    //   'collection_id' => $collections->id
    // ));
    echo $collection->id;
  }


}

?>