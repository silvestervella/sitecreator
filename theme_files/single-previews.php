<?php
/*
 * Template Name: Single Order Template
 * Template Post Type: orders
 */

get_header(); ?>

<main class="site-content text-center dark">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        $heythere_lite_image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'heythere_lite_big');
    ?>

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
