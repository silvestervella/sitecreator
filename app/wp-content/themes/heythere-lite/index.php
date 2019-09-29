<?php get_header(); ?>

    <main class="site-content index">

        <div class="index-title fixed top-1 dark text-center roboto-condensed font-size-1-5 font-weight-700 text-uppercase z-index-3">
            <?php if(is_search()) { ?>
                <h1><?php esc_html_e('Results for:', 'heythere-lite'); ?> <?php echo $s; ?></h1>
            <?php } else if(is_category() || is_tag() ) { ?>
                <h1><?php echo single_cat_title(); ?></h1>
            <?php } else if(is_author()) { ?>
                <h1><?php the_author(); ?></h1>
            <?php } else if(is_front_page()) { ?>
                <h1><?php bloginfo('description'); ?></h1>
            <?php } else { ?>
                <h1><?php echo get_the_title( get_option('page_for_posts', true) );?></h1>
            <?php } ?>
        </div>

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <div class="index-main-title-container absolute bottom-0 width-30 padding-left-6pc padding-right-4-5pc dark">
                    <div class="text-right break-word">
                        <h2 class="color-hover-dark roboto-condensed font-size-1-7 font-weight-700 text-uppercase"><a class="dark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="dark roboto font-size-0-8 font-weight-100"><?php echo the_date( get_option('date_format') ); ?></p>
                        <p class="color-hover soft-dark roboto font-size-0-7 font-weight-300 letter-spacing-0-1 line-height-1-1 text-uppercase"><?php the_category(' / '); ?></p>
                        <p class="index-main-tag roboto font-size-0-7 font-weight-300 letter-spacing-0-1"><?php the_tags('',' '); ?></p>
                    </div>
                </div>
                <div class="index-main-excerpt-container absolute bottom-0 width-70 padding-left-4-5pc padding-right-6pc dark">
                    <div class="roboto font-size-0-8 font-weight-300 text-uppercase letter-spacing-0-1 line-height-1-1"><?php the_excerpt(); ?></div>
                </div>
            </article>
            <hr class="index-main-line">
        <?php endwhile; ?>
        <div id="index-pagination" class="index-pagination">
            <?php
            global $wp_query;
            $big = 999999999;
            echo paginate_links( array(
            	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            	'format' => '?paged=%#%',
            	'current' => max( 1, get_query_var('paged') ),
            	'total' => $wp_query->max_num_pages
            ) );
            ?>
        </div>
        <?php else: ?>
            <p><?php esc_html_e('Sorry, no post matched your criteria.', 'heythere-lite'); ?></p>
        <?php endif; ?>

        <div class="back-to-top-button fixed right-1 bottom-1 z-index-3 border-radius-100 cursor-pointer">
            <div class="text-center border-radius-100 border-1">
                <i class="fa fa-angle-up fa-lg relative vertical-align"></i>
            </div>
        </div>

        <div class="projects-categories soft-dark relative width-100 padding-top-4 padding-bottom-4 padding-left-3pc padding-right-3pc text-center">
            <?php
                $args = array( 'hide_empty' => 0 );
                $terms = get_categories( $args );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    $count = count( $terms );
                    $i = 0;
                    if('posts' == get_option( 'show_on_front' )) {
                        $heythere_lite_blog_title = get_bloginfo('name');
                        $heythere_lite_blog_link = esc_url( home_url( '/' ) );
                    } else {
                        $heythere_lite_blog_title = get_the_title( get_option('page_for_posts', true) );
                        $heythere_lite_blog_link = esc_url( get_the_permalink( get_option('page_for_posts', true) ) );
                    }
                    $term_list = '<p class="color-hover roboto font-size-0-7 font-weight-300 text-uppercase letter-spacing-0-0-5"><a class="soft-dark" href="' . $heythere_lite_blog_link . '">' . $heythere_lite_blog_title . ' /&nbsp; </a>';
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
