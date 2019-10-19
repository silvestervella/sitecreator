<?php
/*
 * Template Name: Quotation Template
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
                    $previewPage = '<div class="theme-options"><div class="view-option"><a target="_blank" class="view-button" href="'.get_post_permalink($previews[0]->ID).'">View</a></div></div>';
                }

                $field .= '<label class="option">
                                <input type="radio" class="calc templates '.$atts['terms'].'" name="templates" value="' . $feature->post_name .'" number="'.$price[0].'">
                                <div class="img-wrap"> <img src="'. get_the_post_thumbnail_url( $feature->ID  ) .'"> </div>
                            </label>'.$previewPage;

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
        $field .= '</div>';
    endif; 
return $field;
}


//php mailer variables
$to = get_option('admin_email');
$subject = "Someone sent a message from ".get_bloginfo('name');
$headers = 'From: '. $email . "\r\n" .
  'Reply-To: ' . $email . "\r\n";

  if(!$human == 0){
    if($human != 2 || !wp_verify_nonce($_POST['submitted'] , 'quote-nonce')) my_contact_form_generate_response("error", $not_human); //not human!
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
                        'post_type'     => 'orders'
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
  
get_header(); ?>

    <main class="site-content text-center dark">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            $heythere_lite_image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'heythere_lite_big');
        ?>

            <article <?php post_class(); ?>>

                <div class="relative width-100 height-50">
                    <div class="relative vertical-align padding-left-3pc padding-right-3pc break-word">
                        <p class="single-category color-hover roboto font-size-0-7 font-weight-100 letter-spacing-0-1 text-uppercase"><?php the_category(' / ');?></p>
                        <h1 class="single-title roboto-condensed font-size-7 font-weight-700 text-uppercase"><?php the_title(); ?></h1>
                        <p class="roboto font-size-0-7 color-hover font-weight-100 letter-spacing-0-1 text-uppercase"><?php the_author_posts_link(); ?> - <?php echo the_date( get_option('date_format') ); ?></p>
                    </div>
                </div>
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
                                <label for="name"><span>Contact Name: <span class="required">*</span></span> <br><input type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>"></label>
                                <label for="company"><span>Company: <span class="optional">(Optional)</span></span> <br><input type="text" name="message_company" value="<?php echo esc_attr($_POST['message_company']); ?>"></label>
                                <label for="message_email"><span>Email: <span class="required">*</span></span> <br><input type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>"></label>
                                <div class="next" >NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                    <div class="template-tabs">
                                    <div class="tablinks" name="blog">Blog</div>
                                    <div class="tablinks" name="ecommerce">Ecommerce</div>
                                    <div class="tablinks" name="portfolio">Portfolio</div>
                                    <div class="tablinks" name="corporate">Corporate</div>
                                    </div>

                                    <!-- Tab content -->
                                    <div id="blog" class="tabcontent">
                                    <?php echo sitecreator_get_prods(array('terms' => 'blog')); ?>
                                    </div>

                                    <div id="ecommerce" class="tabcontent">
                                    <?php echo sitecreator_get_prods(array('terms' => 'e-commerce')); ?>
                                    </div>

                                    <div id="portfolio" class="tabcontent">
                                    <?php echo sitecreator_get_prods(array('terms' => 'portfolio')); ?>
                                    </div>

                                    <div id="corporate" class="tabcontent">
                                    <?php echo sitecreator_get_prods(array('terms' => 'corporate')); ?>
                                    </div>
                                <div class="next">NEXT</div>
                            </fieldset>

                            <fieldset class="quote-sec specs">
                                <?php echo sitecreator_get_prods(array('terms' => 'blogs')); ?>
                                <div class="next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec specs">
                            <?php echo sitecreator_get_prods(array('terms' => 'e-commerces')); ?>
                                <div class="next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec specs">
                                <?php echo sitecreator_get_prods(array('terms' => 'portfolios')); ?>
                                <div class="next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec specs">
                                <?php echo sitecreator_get_prods(array('terms' => 'corporates')); ?>
                                <div class="next">NEXT</div>
                            </fieldset>

                            <fieldset class="quote-sec">
                                <?php echo sitecreator_get_prods(array('terms' => 'images')); ?>
                                <div class="next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <?php echo sitecreator_get_prods(array('terms' => 'customisation')); ?>
                                <div class="next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <?php echo sitecreator_get_prods(array('terms' => 'domain')); ?>
                                <div class="next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <?php echo sitecreator_get_prods(array('terms' => 'hosting')); ?>
                                <div class="next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <div id="quote-items"></div>
                                <label for="message_text"><Span>Any queries or requests?  <span class="optional">(Optional)</span></span> <br><textarea type="text" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea></label>
                                <div class="next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <p><label for="message_human">Human Verification: <span class="required">*</span> <br><input type="text" name="message_human"> + 3 = 5</label></p>
                                <input type="hidden" name="submitted" value="<?php echo wp_create_nonce('quote-nonce'); ?>">
                                <p><input type="submit"></p>
                            </fieldset>
                        </form>
                    </div>



                    <?php if( $numpages > 1 ) { ?>
                        <div class="main-article-pagination">
                            <?php wp_link_pages(); ?>
                        </div>
                    <?php } ?>
                    <div class="single-main-tag text-center roboto"><?php the_tags('',' '); ?></div>
                </div>

                <div class="main-article-next-prev soft-dark width-100 padding-top-3 padding-bottom-3 roboto">
                    <div class="color-hover padding-left-3pc text-right">
                        <?php
                        $prev_post = get_previous_post();
                        if (!empty( $prev_post )): ?>
                            <p class="font-size-0-7 font-weight-100 letter-spacing-0-1"><?php echo esc_html__( 'Prev Post:', 'heythere-lite' ); ?></p>
                            <a  class="text-uppercase font-size-0-8 font-weight-400 letter-spacing-0-0-5" href="<?php echo $prev_post->guid ?>"><?php echo $prev_post->post_title ?></a>
                        <?php endif ?>
                    </div><!--
                    --><div class="color-hover main-article-next-prev-home text-center">
                        <?php
                        function heythere_lite_get_blog_posts_page_url() {
                        	if ( 'page' === get_option( 'show_on_front' ) ) {
                        		return get_permalink( get_option( 'page_for_posts' ) );
                        	}
                        	return get_home_url();
                        }
                        ?>
                        <a class="font-size-1-2" href="<?php echo heythere_lite_get_blog_posts_page_url(); ?>"><i class="fa fa-th-large fa-2x" aria-hidden="true"></i></a>
                    </div><!--
                    --><div class="color-hover padding-right-3pc text-left">
                    <?php
                     $next_post = get_next_post();
                     if (!empty( $next_post )): ?>
                         <p class="font-size-0-7 font-weight-100 letter-spacing-0-1"><?php echo esc_html__( 'Next Post:', 'heythere-lite' ); ?></p>
                         <a class="text-uppercase font-size-0-8 font-weight-400 letter-spacing-0-0-5" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo esc_attr( $next_post->post_title ); ?></a>
                     <?php endif; ?>
                    </div>
                </div>

            </article>

            <div class="comments full-width">

              <?php comments_template(); ?>

            </div>

        <?php endwhile; ?>
        <?php else: ?>

            <p><?php esc_html_e('Sorry, no post matched your criteria.', 'heythere-lite'); ?></p>

        <?php endif; ?>

        <div class="back-to-top-button fixed right-1 bottom-1 z-index-3 border-radius-100 cursor-pointer">
            <div class="text-center border-radius-100 border-1">
                <i class="fa fa-angle-up fa-lg relative vertical-align"></i>
            </div>
        </div>

    </main>

<?php get_footer(); ?>
