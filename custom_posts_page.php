<?php
  function include_template_function( $template_path ) {
    if (get_post_type() == 'artigo' && !is_single()) {
      $template_path = plugin_dir_path( __FILE__ ) . '/custom_posts_page_theme.php';
    }

    return $template_path;
  }

  add_filter('template_include', 'include_template_function', 1 );

  function get_capa_edicao() {
    $edicao = get_term(get_queried_object()->term_id, 'edicao');
    $image_id = get_term_meta( $edicao->term_id, 'image', true );
    $image_data = wp_get_attachment_image_src( $image_id, 'full' );
    $image = $image_data[0];

    return "<img src=\"{$image}\"/>";
  }
  add_shortcode('capa_edicao', 'get_capa_edicao');
?>
