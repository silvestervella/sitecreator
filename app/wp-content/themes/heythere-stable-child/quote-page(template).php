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
$missing_content = "Please supply all information.";
$email_invalid   = "Email Address Invalid.";
$message_unsent  = "Message was not sent. Try Again.";
$message_sent    = "Thanks! Your message has been sent.";
 
//user posted variables
$name = $_POST['message_name'];
$email = $_POST['message_email'];
$message = $_POST['message_text'] + $_POST['template'];
$human = $_POST['message_human'];


 
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
            if(empty($name) || empty($message)){
                my_contact_form_generate_response("error", $missing_content);
            }
            else //ready to go!
            {
                $sent = wp_mail($to, $subject, strip_tags($message), $headers);
                if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
                else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
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
                    <div class="height-50" style="background: url(<?php echo $heythere_lite_image_attributes[0]; ?>); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                    </div>
                <?php } ?>
                <div id="single-main-article-content" class="main-article-content break-word">
                    <?php the_content(); ?>
                    
                    <!-- quotation form -->
                    <div id="respond">
                        <?php echo $response; ?>
                        <form action="<?php the_permalink(); ?>" method="post">
                            <fieldset>
                                <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>"></label></p>
                                <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>"></label></p>
                                <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea></label></p>
                                <p><label for="message_human">Human Verification: <span>*</span> <br><input type="text" style="width: 60px;" name="message_human"> + 3 = 5</label></p>
                            </fieldset>
                            <fieldset>
                                <?php
                                $templatesField = '';
                                $templates = get_posts(array(
                                    'post_type' => 'site-features'
                                ));

                                if ($templates):
                                    $templatesField = '<div">';
                                    ?>

                                    <?php
                                    foreach($templates as $template) {
                                        $templatesField .= '<label>
                                                            <input type="radio" name="template" value="' . $template->post_name . '" >
                                                            <img src="'. get_the_post_thumbnail_url( $template->ID  ) .'">
                                                            </label>';
                                    }
                                    $templatesField .= "</div>";
                                endif; 
                                echo $templatesField; ?>
                            </fieldset>
                            <input type="hidden" name="submitted" value="<?php echo wp_create_nonce('quote-nonce'); ?>">
                            <p><input type="submit"></p>
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
