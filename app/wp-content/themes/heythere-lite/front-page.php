<?php
if ( 'posts' == get_option( 'show_on_front' ) ) {
    include( get_index_template() );
} else { ?>

    <?php get_header(); ?>

        <main id="fullpage">

        <?php
        $args = array(
            'post_type' => 'projects',
            'posts_per_page' => '5'
        );
        $heythere_lite_the_query = new WP_Query( $args );
        while ( $heythere_lite_the_query->have_posts() ) :
        	$heythere_lite_the_query->the_post();
            $heythere_lite_image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'heythere_lite_big');
            $heythere_lite_color_1 = get_post_meta(get_the_ID(),'color_1',true);
            $heythere_lite_color_2 = get_post_meta(get_the_ID(),'color_2',true);
            $heythere_lite_client_name = get_post_meta(get_the_ID(),'client_name',true);
        ?>



            <section class="section relative" style="background: linear-gradient(<?php echo esc_attr($heythere_lite_color_1); ?>,<?php echo esc_attr($heythere_lite_color_1); ?>), url(<?php echo esc_url($heythere_lite_image_attributes[0]); ?>); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                <div class="relative vertical-align z-index-3">
                    <h1 class="home-title color-hover-light width-94 relative left-1 roboto-condensed font-size-7 font-weight-700 text-uppercase break-word">
                        <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a>
                    </h1>
                    <div class="home-underline relative light-background"></div>
                    <div class="home-excerpt-text relative rotate-90 text-right roboto text-uppercase">
                        <div>
                            <?php if( $heythere_lite_client_name != '' ) { ?>
                                <p class="font-size-0-7 font-weight-100 letter-spacing-0-1"><?php echo esc_html__( 'Client:', 'heythere-lite' ); ?></p>
                            <?php } ?>
                            <p class="font-size-1 font-weight-700 letter-spacing-0-0-5"><?php echo esc_html($heythere_lite_client_name); ?></p>
                            <p class="font-weight-hover font-size-0-7 font-weight-300 letter-spacing-0-1 line-height-1-1"><?php the_terms( $post->ID, 'project-type', '', ' / ', '' ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="home-excerpt-background absolute bottom-0" style="background-color:<?php echo esc_attr($heythere_lite_color_2); ?>"></div>
            </section>

        <?php endwhile;
        wp_reset_postdata(); ?>

        </main>

        <div class="fixed bottom-1 right-1 text-right">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'all-projects-link',
                'menu_class' => 'all-projects-menu roboto font-size-0-9 font-weight-500 text-uppercase line-height-1-4 text-shadow-1 letter-spacing-0-0-5',
                'container' => false
            ) );
            ?>
        </div>

    <?php get_footer(); ?>

<?php
}
?>
