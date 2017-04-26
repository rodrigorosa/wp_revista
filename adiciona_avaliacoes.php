<?php

  function get_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'artigo') {
        $single_template = dirname( __FILE__ ) . '/single.php';
     }

     return $single_template;
  }
  add_filter('single_template', 'get_custom_post_type_template');

?>
