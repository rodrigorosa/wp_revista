<?php

function prefix_add_my_stylesheet() {
  // Respects SSL, Style.css is relative to the current file
  wp_register_style( 'prefix-style', plugins_url('wp_revista.css', __FILE__) );
  wp_enqueue_style( 'prefix-style' );
  wp_enqueue_style( 'load-fa', 'https://use.fontawesome.com/c4fe4b8084.js' );
  wp_enqueue_style( 'load-modal-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.8.0/jquery.modal.css' );
}

add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet' );
add_action( 'admin_enqueue_scripts', 'prefix_add_my_stylesheet' );

?>
