<?php
/**
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

get_header();

global $post, $arlo_fn_option;
$arlo_fn_pagetitle 		= '';
$arlo_fn_top_padding 	= '';
$arlo_fn_bot_padding 	= '';
$arlo_fn_page_spaces 	= '';
$arlo_fn_pagestyle 		= '';

if(function_exists('rwmb_meta')){
	$arlo_fn_pagetitle 			= get_post_meta(get_the_ID(),'arlo_fn_page_title', true);
	$arlo_fn_top_padding 		= get_post_meta(get_the_ID(),'arlo_fn_page_padding_top', true);
	$arlo_fn_bot_padding 		= get_post_meta(get_the_ID(),'arlo_fn_page_padding_bottom', true);
	
	$arlo_fn_page_spaces = 'style=';
	if($arlo_fn_top_padding != ''){$arlo_fn_page_spaces .= 'padding-top:'.$arlo_fn_top_padding.'px;';}
	if($arlo_fn_bot_padding != ''){$arlo_fn_page_spaces .= 'padding-bottom:'.$arlo_fn_bot_padding.'px;';}
	if($arlo_fn_top_padding == '' && $arlo_fn_bot_padding == ''){$arlo_fn_page_spaces = '';}
	
	// page styles
	$arlo_fn_pagestyle 			= get_post_meta(get_the_ID(),'arlo_fn_page_style', true);
}
// CHeck if page is password protected	
if(post_password_required($post)){
	echo '<div class="arlo_fn_password_protected">
		 	<div class="in">
				<div>
					<div class="message_holder">
						<h1>'.esc_html__('Protected','arlo').'</h1>
						<h3>'.esc_html__('This page was protected','arlo').'</h3>
						'.get_the_password_form().'
						<div class="icon_holder"><i class="xcon-lock"></i></div>
					</div>
				</div>
		  	</div>
		  </div>';
}
else
{

?>
<div class="arlo_fn_all_pages_content">


	<!-- ALL PAGES -->		
	<div class="arlo_fn_all_pages">
		<div class="arlo_fn_all_pages_inner">

			<?php if($arlo_fn_pagestyle == 'full' || $arlo_fn_pagestyle == ''){ ?>

			<!-- WITHOUT SIDEBAR -->
			<div class="arlo_fn_without_sidebar_page">
				<div class="container">
				
					<?php if($arlo_fn_pagetitle !== 'disable'){ ?>
						<!-- PAGE TITLE -->
						<div class="arlo_fn_pagetitle">
							<div class="title_holder">
								<h3><?php the_title(); ?></h3>
								<?php arlo_fn_breadcrumbs();?>
							</div>
						</div>
						<!-- /PAGE TITLE -->
					<?php } ?>
					
					<div class="inner" <?php echo esc_attr($arlo_fn_page_spaces); ?>>
					
						
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php the_content(); ?>
							<div class="fn_link_pages">
								<?php wp_link_pages(
									array(
										'before'      => '<div class="arlo_fn_pagelinks"><span class="title">' . __( 'Pages:', 'arlo' ). '</span>',
										'after'       => '</div>',
										'link_before' => '<span class="number">',
										'link_after'  => '</span>',
									)
								); ?>
							</div>
							<?php if ( comments_open() || get_comments_number()){?>
							<!-- Comments -->
							<div class="arlo_fn_comment" id="comments">
								<?php comments_template(); ?>
							</div>
							<!-- /Comments -->
							<?php } ?>

						<?php endwhile; endif; ?>

					</div>
				</div>
			</div>
			<!-- /WITHOUT SIDEBAR -->

			<?php }else{ ?>

			<!-- WITH SIDEBAR -->
			<div class="arlo_fn_sidebarpage">
				<div class="container">
					<?php if($arlo_fn_pagetitle !== 'disable'){ ?>
						<!-- PAGE TITLE -->
						<div class="arlo_fn_pagetitle">
							<div class="title_holder">
								<h3><?php the_title(); ?></h3>
							</div>
							<?php arlo_fn_breadcrumbs();?>
						</div>
						<!-- /PAGE TITLE -->
					<?php } ?>
					<div class="s_inner">

						<div class="arlo_fn_leftsidebar" <?php echo esc_attr($arlo_fn_page_spaces); ?>>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

								<?php the_content(); ?>

								<?php if ( comments_open() || get_comments_number()){?>
								<!-- Comments -->
								<div class="arlo_fn_comment" id="comments">
									<?php comments_template(); ?>
								</div>
								<!-- /Comments -->
							<?php } ?>

							<?php endwhile; endif; ?>
						</div>

						<div class="arlo_fn_rightsidebar" <?php echo esc_attr($arlo_fn_page_spaces); ?>>
							<?php get_sidebar(); ?>
						</div>
					</div>
				</div>
			</div>
			<!-- /WITH SIDEBAR -->

			<?php } ?>

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
                                                <div class="tablinks" name="corporate">Business</div>
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

                                    <fieldset class="quote-sec specs blog">
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

                                    <fieldset class="quote-sec specs e-commerce">
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

                                    <fieldset class="quote-sec specs portfolio">
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
                                    
                                    <fieldset class="quote-sec specs corporate">
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


		</div>
	</div>		
	<!-- /ALL PAGES -->
</div>
<?php } ?>

<?php get_footer(); ?>  