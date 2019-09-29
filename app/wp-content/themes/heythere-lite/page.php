<?php get_header(); ?>

    <main class="text-center dark">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            $heythere_lite_image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'heythere_lite_big');
        ?>

            <article <?php post_class(); ?>>

                <div class="relative width-100 height-50">
                    <div class="relative vertical-align padding-left-3pc padding-right-3pc break-word">
                        <h1 class="roboto-condensed font-size-7 font-weight-700 text-uppercase text-shadow-1"><?php the_title(); ?></h1>
                    </div>
                </div>
                <?php
                if ( has_post_thumbnail() ) { ?>
                    <div class="height-50" style="background: url(<?php echo $heythere_lite_image_attributes[0]; ?>); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                    </div>
                <?php } ?>
                <div id="page-main-article-content" class="main-article-content break-word">
                    <?php the_content(); ?>
                    <?php if( $numpages > 1 ) { ?>
                        <div class="main-article-pagination">
                            <?php wp_link_pages(); ?>
                        </div>
                    <?php } ?>
                </div>

            </article>

        <?php endwhile; else: ?>

            <p><?php esc_html_e('Sorry, no post matched your criteria.', 'heythere-lite'); ?></p>

        <?php endif; ?>

        <div class="back-to-top-button fixed right-1 bottom-1 z-index-3 border-radius-100 cursor-pointer">
            <div class="text-center border-radius-100 border-1">
                <i class="fa fa-angle-up fa-lg relative vertical-align"></i>
            </div>
        </div>

    </main>

<?php get_footer(); ?>
