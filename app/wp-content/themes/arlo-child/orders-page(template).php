<?php
/*
 * Template Name: Orders Template
 * Template Post Type: post, page
 */

$orders = get_posts(
    array(
    'post_type' => 'orders',
    'post_status' => 'private'
    )
);
$order_post = '';

get_header(); 
   
    foreach ($orders as $order) {
        $order_post .= '<div class="post-wrap">';
    
        $order_post .= '<h3>'.$order->post_title. '<span>'. $order->post_date.'</span></h3>';
    
        $order_post .=  '<div class"achiev-desc">' . $order->post_content .'</div>';
    
        $order_post .= '</div>'; //.post-wrap
    }
    echo $order_post;


get_footer(); ?>


