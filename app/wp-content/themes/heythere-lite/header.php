<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <!-- MENU SECTION -->
    <section id="off-canvas-menu" class="dark-background fixed width-100 height-100 z-index-5">
        <div id="close-menu-button" class="absolute top-1 right-1 z-index-5 text-right">
            <button class="grow-hover cursor-pointer light roboto font-size-0-9 font-weight-500 letter-spacing-0-0-5 text-uppercase"><?php echo esc_html__( 'Close', 'heythere-lite' ) ?></button>
        </div>
        <div class="off-canvas-menu-info width-30 height-100 float-left">
            <div class="relative height-50 border-bottom-1">
                <p id="menu-description" class="absolute bottom-0 right-0 rotate-90 padding-left-1 roboto font-size-0-8 font-weight-300 letter-spacing-0-0-5 line-height-1-1 text-uppercase"><?php bloginfo('description'); ?></p>
            </div>
            <div class="text-right">
                <p class="margin-top-1 roboto font-size-0-7 font-weight-100 letter-spacing-0-1 text-uppercase"><?php esc_html_e( '&copy;', 'heythere-lite' )?> <?php echo get_the_date( 'Y' ); ?> <?php bloginfo('name')?></p>
            </div>
        </div>
        <div class="off-canvas-menu-menu width-70 height-100 padding-left-4-5pc padding-right-6pc float-left break-word">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'main-menu',
                'menu_class' => 'off-canvas-menu-menu-item color-hover-light relative vertical-align roboto-condensed font-size-7 font-weight-700 text-uppercase',
                'container' => false
            ));
            ?>
        </div>
        <div class="absolute vertical-align right-1">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'social-menu',
                'menu_class' => 'social-menu relative',
                'container' => false,
                'link_before' => '<span class="screen-reader-text">', // Hide the social links text
                'link_after' => '</span>', // Hide the social links text
            ));
            ?>
        </div>
    </section>

    <!-- LOGO & OPEN MENU BUTTON -->
    <header class="width-100 fixed top-0 z-index-4">

        <?php if ( (is_front_page() && 'page'== get_option( 'show_on_front' ) ) || is_singular('projects') || is_page_template('all-projects.php') || is_tax('project-type') ) { ?>

            <?php if ( get_theme_mod( 'custom_logo' ) ) { ?>
                <div class="absolute left-1 vertical-align">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php echo '<img class="custom-logo grow-hover cursor-pointer" src="'. esc_url(get_theme_mod( 'custom_logo' )) .'">'; ?>
                    </a>
                </div>
            <?php } else { ?>
                <div id="logo" class="absolute left-1 vertical-align">
                    <a class="grow-hover light roboto font-size-1 font-weight-500 text-uppercase letter-spacing-0-0-5" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a>
                </div>
            <?php } ?>
            <div id="open-menu-button" class="absolute right-1 vertical-align">
                <button class="grow-hover cursor-pointer light roboto font-size-0-9 font-weight-500 text-uppercase letter-spacing-0-0-5"><?php echo esc_html__( 'Menu', 'heythere-lite' ) ?></button>
            </div>

        <?php } else { ?>

            <?php if ( get_theme_mod( 'custom_logo_2' ) ) { ?>
                <div class="absolute left-1 vertical-align">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php echo '<img class="custom-logo grow-hover cursor-pointer" src="'. esc_url(get_theme_mod( 'custom_logo_2' )) .'">'; ?>
                    </a>
                </div>
            <?php } else { ?>
                <div id="logo" class="absolute left-1 vertical-align">
                    <a class="grow-hover dark roboto font-size-1 font-weight-500 text-uppercase letter-spacing-0-0-5" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a>
                </div>
            <?php } ?>
            <div id="open-menu-button" class="absolute right-1 vertical-align">
                <button class="grow-hover cursor-pointer dark roboto font-size-0-9 font-weight-500 text-uppercase letter-spacing-0-0-5"><?php echo esc_html__( 'Menu', 'heythere-lite' ) ?></button>
            </div>

        <?php } ?>

    </header>
