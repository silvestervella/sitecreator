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

<article <?php post_class(); ?>>
    <div class="relative width-100 height-50">
        <div class="relative vertical-align padding-left-3pc padding-right-3pc break-word">
            <p class="single-category color-hover roboto font-size-0-7 font-weight-100 letter-spacing-0-1 text-uppercase"><?php the_category(' / ');?></p>
            <h1 class="single-title roboto-condensed font-size-7 font-weight-700 text-uppercase"><?php the_title(); ?></h1>
            <p class="roboto font-size-0-7 color-hover font-weight-100 letter-spacing-0-1 text-uppercase"><?php the_author_posts_link(); ?> - <?php echo the_date( get_option('date_format') ); ?></p>
        </div>
    </div>
    <?php 
    $previewSites = '';
    $siteLinks = get_post_meta(get_the_ID()); 

    foreach ($siteLinks as $key => $link) {
        if (strpos($key, 'theme-option') !== false) {
            $previewSites .= '<div class="option-number">'.strtoupper(preg_replace("/[^a-zA-Z0-9]+/", " ", $key)).'</div>';
            $previewSites .= '<iframe src="'.$link[0].'" class="preview-frames"></iframe>';
        }
    }
    echo $previewSites;
    ?>
</article>

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
