<?php

function prefix_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'prefix-style', plugins_url('wp_revista.css', __FILE__) );
    wp_enqueue_style( 'prefix-style' );
}
add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet' );

?>
