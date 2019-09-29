<?php get_header(); ?>

    <main>

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            $heythere_lite_image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'heythere_lite_big');
            $heythere_lite_color_1 = get_post_meta(get_the_ID(),'color_1',true);
            $heythere_lite_color_2 = get_post_meta(get_the_ID(),'color_2',true);
            $heythere_lite_client_name = get_post_meta(get_the_ID(),'client_name',true);
        ?>

            <article <?php post_class(); ?>>

                <div id="single-project-main-thumnail-container" class="single-project-main-thumnail-container parallax relative width-100 height-50" style="background: linear-gradient(<?php echo esc_attr($heythere_lite_color_1); ?>,<?php echo esc_attr($heythere_lite_color_1); ?>), url(<?php echo esc_url($heythere_lite_image_attributes[0]); ?>); background-size: cover; background-position: center center; background-repeat: no-repeat; background-attachment:fixed;">
                    <div class="relative vertical-align padding-left-3pc padding-right-3pc text-center break-word">
                        <p class="single-projects-custom-taxonomy-categories font-weight-hover roboto font-size-0-7 font-weight-100 letter-spacing-0-1 text-uppercase"><?php the_terms( $post->ID, 'project-type', '', ' / ', '' ); ?></p>
                        <h1 class="single-projects-title light roboto-condensed font-size-7 font-weight-700 text-uppercase"><?php the_title(); ?></h1>
                        <?php if( $heythere_lite_client_name != '' ) { ?>
                            <p class="single-projects-client roboto font-size-0-7 font-weight-100 letter-spacing-0-1 text-uppercase"><?php echo esc_html__( 'Client:', 'heythere-lite' ); ?></p>
                        <?php } ?>
                        <p class="roboto font-size-1 font-weight-700 letter-spacing-0-0-5 text-uppercase"><?php echo esc_html($heythere_lite_client_name); ?></p>
                    </div>
                </div>
                <div class="single-project-main-article-content main-article-content break-word">
                    <?php the_content(); ?>
                    <?php if( $numpages > 1 ) { ?>
                        <div class="main-article-pagination">
                            <?php wp_link_pages(); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="main-article-next-prev soft-dark width-100 padding-top-3 padding-bottom-3 roboto">
                    <div class="color-hover padding-left-3pc text-right">
                        <?php
                        $prev_post = get_previous_post();
                        if (!empty( $prev_post )): ?>
                           <p class="font-size-0-7 font-weight-100 letter-spacing-0-1"><?php echo esc_html__( 'Prev Project:', 'heythere-lite' ); ?></p>
                            <a  class="text-uppercase font-size-0-8 font-weight-400 letter-spacing-0-0-5" href="<?php echo $prev_post->guid ?>"><?php echo $prev_post->post_title ?></a>
                        <?php endif ?>
                    </div><!--
                    --><div class="color-hover main-article-next-prev-home text-center">
                        <?php
                        $pages = get_pages(array(
                            'meta_key' => '_wp_page_template',
                            'meta_value' => 'all-projects.php'
                        ));
                        foreach($pages as $page){
                            $all_projects_title = get_the_title($page->ID);
                            $all_projects_link = esc_url( get_the_permalink($page->ID) );
                        }
                        ?>
                        <a class="font-size-1-2" href="<?php echo $all_projects_link ?>"><i class="fa fa-th-large fa-2x" aria-hidden="true"></i></a>
                    </div><!--
                    --><div class="color-hover padding-right-3pc text-left">
                       <?php
                        $next_post = get_next_post();
                        if (!empty( $next_post )): ?>
                            <p class="font-size-0-7 font-weight-100 letter-spacing-0-1"><?php echo esc_html__( 'Next Project:', 'heythere-lite' ); ?></p>
                            <a class="text-uppercase font-size-0-8 font-weight-400 letter-spacing-0-0-5" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo esc_attr( $next_post->post_title ); ?></a>
                        <?php endif; ?>
                    </div>
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
