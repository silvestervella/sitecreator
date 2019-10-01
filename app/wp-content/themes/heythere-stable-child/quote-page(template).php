<?php
/*
 * Template Name: Products Template
 * Template Post Type: post, page
 */

get_header(); ?>

<?php global $woocommerce; ?>
 <a class="your-class-name" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"
title="<?php _e('Cart View', 'woothemes'); ?>">
<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'),
 $woocommerce->cart->cart_contents_count);?>  -
<?php echo $woocommerce->cart->get_cart_total(); ?>
</a>

<?php

$loop = new WP_Query( array(
    'post_type' => 'product',
    'posts_per_page' => 12,
) );

if ($loop->have_posts()) {
    while ($loop->have_posts()): $loop->the_post();
      $product = wc_get_product($loop->post->ID);

      if ($product->is_type( 'variable' )) 
{
    $available_variations = $product->get_available_variations();
    foreach ($available_variations as $key => $value) 
    { 
        // values
    }
}
      ?>
        <!-- tab product -->
        <li class="col-sx-12 col-sm-4">
          <div class="product-container">
            <div class="left-block">
              <a href="<?php echo get_permalink(); ?>" target="_blank">
                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($loop->post->ID), 'single-post-thumbnail');?>
                <img height="300px" width="300px" class="img-responsive" alt="product" src="<?php echo $image[0]; ?>">
                </a>
                <input type="radio" name="gender" value="male"><br>
              <div class="add-to-cart "><?php
                echo sprintf( '<a href="%s" data-quantity="1" class="%s" %s>%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( implode( ' ', array_filter( array(
                        'button', 'product_type_' . $product->get_type(),
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                    ) ) ) ),
                    wc_implode_html_attributes( array(
                        'data-product_id'  => $product->get_id(),
                        'data-product_sku' => $product->get_sku(),
                        'aria-label'       => $product->add_to_cart_description(),
                        'rel'              => 'nofollow',
                    ) ),
                    esc_html( $product->add_to_cart_text() )
                );
              ?></div>
            </div>
          </div>
        </li>
      <?php
    endwhile;
}
echo "</ul>";
wp_reset_postdata();
?>

<?php get_footer();?>