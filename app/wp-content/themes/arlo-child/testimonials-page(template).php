<?php
/*
 * Template Name: Testimonials Form
 * Template Post Type: post, page
 */
 
//response generation function
$response = "";

//function to generate response
function my_contact_form_generate_response($type, $message){

  global $response;

  if($type == "success") $response = "<div class='success'>{$message}</div>";
  else $response = "<div class='error'>{$message}</div>";

}

//response messages
$not_human       = "Human verification incorrect.";
$missing_content = "Please supply all required* information.";
$missing_content_not_sent = "Order not sent! Please supply all required* information.";
$email_invalid   = "Email Address Invalid.";
$message_unsent  = "Message was not sent. Try Again.";
$message_sent    = "Thanks! Your Order has been submitted. We'll get back to you soon.";
 
//user posted variables
$selected_template = (string)$_POST['templates'];
$selected_specs = (string)$_POST['specifications'];
$selected_images = (string)$_POST['images'];
$selected_customisation = (string)$_POST['customisation'];
$selected_domain = (string)$_POST['domain'];
$selected_hosting = (string)$_POST['hosting'];

$name = $_POST['message_name'];
$company = $_POST['message_company'];
$email = $_POST['message_email'];
$message = $_POST['message_text'];
$human = $_POST['message_human'];


function sitecreator_get_prods($atts) {

    $field = '';
    $features = get_posts(array(
        'post_type' => 'site-features',
        'posts_per_page'=>-1, 
        'numberposts'=>-1,
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => $atts['terms'],
            )
        )
    ));

    if ($features):
       $field = '<div class="options">';
        foreach($features as $feature) {
            if (has_term('templates' , 'type' , $feature->ID)) {
                $previews = get_posts(array(
                    'post_type' => 'previews',
                    'posts_per_page'=>-1, 
                    'numberposts'=>-1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'template',
                            'field' => 'slug',
                            'terms' => 'ID - '.$feature->ID,
                        )
                    )
                ));

                $price = get_post_meta($feature->ID, 'price');
                $previewPage = '';
                if ($previews) {
                    $previewPage = '<div class="theme-options"><div class="view-option"><span class="view-button" url="'.get_post_permalink($previews[0]->ID).'">View</span></div></div>';
                }

                $field .= '<label class="option">
                                <input type="radio" class="calc templates '.$atts['terms'].'" name="templates" value="' . $feature->post_name .'" number="'.$price[0].'">
                                <div class="img-wrap"> <img src="'. get_the_post_thumbnail_url( $feature->ID  ) .'"> </div>
                            '.$previewPage.'</label>';

            } else if (has_term('specifications' , 'type' , $feature->ID)) {
                $price = get_post_meta($feature->ID, 'price');
                $field .= '<label class="option">
                                <input type="radio" class="calc specifications '.$atts['terms'].'" name="specifications" value="' . $feature->post_name .'" number="'.$price[0].'">
                                <div class="img-wrap"> <img src="'. get_the_post_thumbnail_url( $feature->ID  ) .'"> </div>
                            </label>';
            } else {
            $price = get_post_meta($feature->ID, 'price');
            $field .= '<label class="option">
                            <input type="radio" class="calc" name="'. $atts['terms'].'" value="' . $feature->post_name .'" number="'.$price[0].'">
                            <div class="img-wrap"> <img src="'. get_the_post_thumbnail_url( $feature->ID  ) .'"> </div>
                        </label>';
            }
        }
        $field .= '</div><!-- /.options -->';
    endif; 
return $field;
}


//php mailer variables
$to = get_option('admin_email');
$subject = "Someone sent a message from ".get_bloginfo('name');
$headers = 'From: '. $email . "\r\n" .
  'Reply-To: ' . $email . "\r\n";

  if(!$human == 0){
    if($human != 2 || !wp_verify_nonce($_POST['submitted'] , 'testi-form-nonce')) my_contact_form_generate_response("error", $not_human); //not human!
    else {
        //validate email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        my_contact_form_generate_response("error", $email_invalid);
        else //email is valid
        {
            //validate presence of name and message
            if(empty($name) || empty($selected_template) || empty($selected_images) || empty($selected_customisation) || empty($selected_domain) || empty($selected_hosting) || empty($selected_specs) ) {
                my_contact_form_generate_response("error", $missing_content);
            }
            else //ready to go!
            {
                $site_info = 'Template - ' 
                . $selected_template . ' Images - ' 
                . $selected_images . ' Customisation - ' 
                . $selected_customisation . ' Domain - ' 
                . $selected_domain . ' Hosting - ' 
                . $selected_hosting . ' Comments - ' 
                . $message;

                $sent = wp_mail($to, $subject, strip_tags($site_info), $headers);
                if($sent) {
                    my_contact_form_generate_response("success", $message_sent); //message sent!
                    $order_cpt = array(
                        'post_title'    => $name,
                        'post_content'  => $site_info . ' Email - ' .$email ,
                        'post_status'   => 'private',
                        'post_author'   => 1,
                        'post_type'     => 'post'
                      );
                      wp_insert_post( $order_cpt );
                } else {
                    my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
                }
            }
        }
    }
  }
  else my_contact_form_generate_response("error", $missing_content);

  get_header();
  ?>
  <div class="section service-section">
      <div class="container">
          <div class="row">
                  <?php
                  while ( have_posts() ) :
                      the_post();
                  ?>	
                  <div class="custom-col-12">

                          <main class="site-content text-center dark">
                              <article <?php post_class(); ?>>
                                  <?php
                                  if ( has_post_thumbnail() ) { ?>
                                      <!--<div class="height-50" style="background: url( echo $heythere_lite_image_attributes[0];); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                                      </div>-->
                                  <?php } ?>
                                  <div id="single-main-article-content" class="main-article-content break-word">
                                      <?php the_content(); ?>
                                      
                                      <!-- quotation form -->
                                      <div id="respond">
                                          <?php echo $response; ?>
                                          <form id="quote-form" action="<?php the_permalink(); ?>" method="post">
                                              <fieldset class="quote-sec active">
                                                  <label for="name"><span>Your Name: <span class="required">*</span></span> <br><input type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>"></label>
                                                  <label for="company"><span>Company: <span class="optional">(Optional)</span></span> <br><input type="text" name="message_company" value="<?php echo esc_attr($_POST['message_company']); ?>"></label>
                                                  <label for="message_email"><span>Email: <span class="required">*</span></span> <br><input type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>"></label>
                                                  <div class="prev-next next" >NEXT</div>
                                              </fieldset>
                                              <fieldset class="quote-sec">
                                                  <div id="quote-items"></div>
                                                  <label for="message_text"><Span>Please write your message.</span> <br><textarea type="text" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea></label>
                                                  <div class="prev-next prev">PREVIOUS</div>
                                                  <div class="prev-next next">NEXT</div>
                                              </fieldset>
                                              <fieldset class="quote-sec">
                                                  <p><label for="message_human">Human Verification: <span class="required">*</span> <br> + 3 = 5 <br><input type="text" name="message_human"></label></p>
                                                  <input type="hidden" name="submitted" value="<?php echo wp_create_nonce('testi-form-nonce'); ?>">
                                                  <div class="prev-next prev">PREVIOUS</div>
                                                  <input class="submit prev-next" type="submit">
                                              </fieldset>
                                          </form>
                                      </div>
                                  </div>
                  
                              </article>
                      </main>
    
                  </div>
                  <?php endwhile; // End of the loop.?>
          </div>
      </div>
  </div>
  
  <?php get_footer();