<?php
/*
 * Template Name: Products Template 2
 * Template Post Type: post, page
 */

get_header(); ?>

<a href="<?php the_permalink(); ?>" class="more">More info</a><?php
if($available){?><a href="<?php
                $add_to_cart = do_shortcode('[add_to_cart_url id="'.$post->ID.'"]');
                echo $add_to_cart;
?>" class="more">Buy now</a>
                    <?php 
                }

get_footer();?>