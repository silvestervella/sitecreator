<?php get_header(); ?>

    <main>

        <div class="all-projects-title fixed top-1 light text-center roboto-condensed font-size-1-5 font-weight-700 text-uppercase text-shadow-2 z-index-2">
            <h1><?php echo single_term_title(); ?></h1>
        </div>

        <?php
        $term_id = get_queried_object_id();
        $args = array(
            'post_type' => 'projects',
            'posts_per_page' => '-1',
            'tax_query' => array(
                array(
                    'taxonomy' => 'project-type',
                    'terms' => $term_id
                )
            )
        );
        $heythere_lite_the_query = new WP_Query( $args );
        while ( $heythere_lite_the_query->have_posts() ) :
        	$heythere_lite_the_query->the_post();
            $heythere_lite_image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'heythere_lite_big');
            $heythere_lite_color_1 = get_post_meta(get_the_ID(),'color_1',true);
            $heythere_lite_color_2 = get_post_meta(get_the_ID(),'color_2',true);
            $heythere_lite_client_name = get_post_meta(get_the_ID(),'client_name',true);
        ?>

            <section class="relative height-33" style="background: linear-gradient(<?php echo esc_attr($heythere_lite_color_1); ?>,<?php echo esc_attr($heythere_lite_color_1); ?>), url(<?php echo esc_url($heythere_lite_image_attributes[0]); ?>); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                <div class="all-project-main-title-container absolute bottom-0 width-30 padding-left-6pc padding-right-4-5pc border-right-1 break-word">
                    <h2 class="all-projects-main-title color-hover-light relative text-right roboto-condensed font-size-1-7 font-weight-700 text-uppercase"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h2>
                    <div class="text-right text-uppercase">
                        <?php if( $heythere_lite_client_name != '' ) { ?>
                            <p class="roboto font-size-0-7 font-weight-100 letter-spacing-0-1 text-uppercase"><?php echo esc_html__( 'Client:', 'heythere-lite' ); ?></p>
                        <?php } ?>
                        <p class="roboto font-size-1 font-weight-700 letter-spacing-0-0-5 text-uppercase"><?php echo esc_html($heythere_lite_client_name); ?></p>
                        <p class="single-projects-custom-taxonomy-categories font-weight-hover roboto font-size-0-7 font-weight-300 letter-spacing-0-1 line-height-1-1 text-uppercase"><?php the_terms( $post->ID, 'project-type', '', ' / ', '' ); ?></p>
                    </div>
                </div>
                <div class="all-projects-main-excerpt-container absolute bottom-0 width-70 padding-left-4-5pc padding-right-6pc">
                    <div class="all-projects-main-excerpt roboto font-size-0-8 font-weight-300 text-uppercase letter-spacing-0-1 line-height-1-1"><?php the_excerpt(); ?></div>
                </div>
            </section>

        <?php endwhile;
        wp_reset_postdata();
        ?>

        <div class="back-to-top-button fixed right-1 bottom-1 z-index-3 border-radius-100 cursor-pointer">
            <div class="text-center border-radius-100 border-1">
                <i class="fa fa-angle-up fa-lg relative vertical-align"></i>
            </div>
        </div>

        <div class="projects-categories light-background soft-dark relative width-100 padding-top-4 padding-bottom-4 padding-left-3pc padding-right-3pc text-center">
            <?php
                $args = array( 'hide_empty' => 0 );
                $terms = get_terms( 'project-type', $args );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    $count = count( $terms );
                    $i = 0;
                    $pages = get_pages(array(
                        'meta_key' => '_wp_page_template',
                        'meta_value' => 'all-projects.php'
                    ));
                    foreach($pages as $page){
                        $heythere_lite_all_projects_title = get_the_title($page->ID);
                        $heythere_lite_all_projects_link = esc_url( get_the_permalink($page->ID) );
                    }
                    $term_list = '<p class="color-hover roboto font-size-0-7 font-weight-300 text-uppercase letter-spacing-0-0-5"><a class="soft-dark" href="' . $heythere_lite_all_projects_link . '">' . $heythere_lite_all_projects_title . ' /&nbsp; </a>';
                    foreach ( $terms as $term ) {
                        $i++;
                        $term_list .= '<a class="soft-dark line-height-1-3" href="' . get_term_link( $term ) . '" title="' . sprintf( __( 'View all post filed under %s', 'heythere-lite' ), $term->name ) . '">' . $term->name . '</a>';
                        if ( $count != $i ) {
                            $term_list .= ' / ';
                        }
                        else {
                            $term_list .= '</p>';
                        }
                    }
                    echo $term_list;
                }
            ?>
        </div>

    </main>


<?php get_footer(); ?>
