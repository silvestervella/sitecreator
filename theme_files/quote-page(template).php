<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package RT_Portfolio
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
				<div class="custom-col-4">
					<header class="entry-header heading">
						<h2 class="entry-title"><?php the_title();?></h2>
					</header>
				</div>	
				<div class="custom-col-8">
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
                                <div class="prev-next next" >NEXT</div>
                            </fieldset>


                            <fieldset class="quote-sec">
                                <div class="fieldset-title">
                                    <h3>TEMPLATES</h3>
                                    <div class="fieldset-desc">
                                        Choose your category, then your template. Press the View button to preview it live.
                                    </div>
                                </div>
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
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>

                            <fieldset class="quote-sec specs">
                                <div class="fieldset-title">
                                    <h3>Specifications</h3>
                                    <div class="fieldset-desc">
                                        Choose the specifications for your category.
                                    </div>
                                </div>
                                <?php echo sitecreator_get_prods(array('terms' => 'blogs')); ?>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>

                            <fieldset class="quote-sec specs">
                                <div class="fieldset-title">
                                    <h3>Specifications</h3>
                                    <div class="fieldset-desc">
                                        Choose the specifications for your category.
                                    </div>
                                </div>
                            <?php echo sitecreator_get_prods(array('terms' => 'e-commerces')); ?>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>

                            <fieldset class="quote-sec specs">
                                <div class="fieldset-title">
                                    <h3>Specifications</h3>
                                    <div class="fieldset-desc">
                                        Choose the specifications for your category.
                                    </div>
                                </div>
                                <?php echo sitecreator_get_prods(array('terms' => 'portfolios')); ?>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>

                            <fieldset class="quote-sec specs">
                                <div class="fieldset-title">
                                    <h3>Specifications</h3>
                                    <div class="fieldset-desc">
                                        Choose the specifications for your category.
                                    </div>
                                </div>
                                <?php echo sitecreator_get_prods(array('terms' => 'corporates')); ?>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>

                            <fieldset class="quote-sec">
                                <div class="fieldset-title">
                                    <h3>Images</h3>
                                    <div class="fieldset-desc">
                                        Choose your images.
                                    </div>
                                </div>
                                <?php echo sitecreator_get_prods(array('terms' => 'images')); ?>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <div class="fieldset-title">
                                    <h3>Customisation</h3>
                                    <div class="fieldset-desc">
                                        Choose the specific customisation for your site.
                                    </div>
                                </div>
                                <?php echo sitecreator_get_prods(array('terms' => 'customisation')); ?>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <div class="fieldset-title">
                                    <h3>Domain</h3>
                                    <div class="fieldset-desc">
                                        Do you need a domain name? <span>(www.yourdomain.com)</span>
                                    </div>
                                </div>
                                <?php echo sitecreator_get_prods(array('terms' => 'domain')); ?>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <div class="fieldset-title">
                                    <h3>Hosting</h3>
                                    <div class="fieldset-desc">
                                        Do you need hosting for your site?
                                    </div>
                                </div>
                                <?php echo sitecreator_get_prods(array('terms' => 'hosting')); ?>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <div id="quote-items"></div>
                                <label for="message_text"><Span>Any queries or requests?  <span class="optional">(Optional)</span></span> <br><textarea type="text" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea></label>
                                <div class="prev-next prev">PREVIOUS</div>
                                <div class="prev-next next">NEXT</div>
                            </fieldset>
                            <fieldset class="quote-sec">
                                <p><label for="message_human">Human Verification: <span class="required">*</span> <br> + 3 = 5 <br><input type="text" name="message_human"></label></p>
                                <input type="hidden" name="submitted" value="<?php echo wp_create_nonce('quote-nonce'); ?>">
                                <div class="prev-next prev">PREVIOUS</div>
                                <input class="submit prev-next" type="submit">
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

            </article>
            </main>
            <iframe id="preview-frame" src=""></iframe>
            <div id="iframe-close"><span>Close</span></div>
					<div class="service-detail-wrapper">				

						<?php get_template_part( 'template-parts/content', 'single' ); 

						the_post_navigation();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;	
						?>
					</div>
				</div>
				<?php 

				endwhile; // End of the loop.
				?>
		</div>
	</div>
</div>

<?php
get_footer();
