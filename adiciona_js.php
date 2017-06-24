<?php

  function enqueue_load_fa() {
    wp_enqueue_script( 'load-fa', 'https://use.fontawesome.com/c4fe4b8084.js'  );
    wp_enqueue_script( 'load-modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.8.0/jquery.modal.min.js'  );
    wp_enqueue_script( 'revista-scripts', plugins_url('wp_revista.js', __FILE__) );
  }

  add_action( 'admin_enqueue_scripts', 'enqueue_load_fa' );

?>
