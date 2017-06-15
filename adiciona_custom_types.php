<?php

if ( !function_exists( 'registrar_artigos' ) ) {

  // Adicionar status
  function adicionar_status() {
    register_post_status('em_revisao', array(
      'label'                     => _x( 'Em Revisão', 'post' ),
      'public'                    => false,
      'private'                   => true,
      'exclude_from_search'       => false,
      'show_in_admin_all_list'    => true,
      'show_in_admin_status_list' => true,
      'label_count'               => _n_noop( 'Em revisão <span class="count">(%s)</span>', 'Em revisão <span class="count">(%s)</span>' ),
    ));

    register_post_status('revisado', array(
      'label'                     => _x( 'Revisado', 'post' ),
      'public'                    => false,
      'private'                   => true,
      'exclude_from_search'       => false,
      'show_in_admin_all_list'    => true,
      'show_in_admin_status_list' => true,
      'label_count'               => _n_noop( 'Revisado <span class="count">(%s)</span>', 'Revisado <span class="count">(%s)</span>' ),
    ));
  }


	/* Adicionando Custom Type Artigo */
	function registrar_artigos()
	{
		$descricao = 'Usado para listar os artigos da Revista';
		$singular = 'Artigo';
		$plural = 'Artigos';

		$labels = array(
			'name' => $plural,
			'singular_name' => $singular,
			'view_item' => 'Ver ' . $singular,
			'edit_item' => 'Editar ' . $singular,
			'new_item' => 'Novo ' . $singular,
			'add_new_item' => 'Adicionar novo ' . $singular
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields'
		);

		$args = array(
			'labels' => $labels,
			'description' => $descricao,
			'public' => true,
			'menu_icon' => 'dashicons-admin-home',
			'supports' => $supports
		);


		register_post_type('artigo', $args);
    adicionar_status();
	}


	add_action('init', 'registrar_artigos', 0);


  // Adicionar Status no select do artigo
  function option_helper($post, $value, $label) {
    $selected = $post->post_status == $value ? 'selected' : '';
    return "<option value='{$value}' {$selected}>{$label}</option>";
  }
  function jc_append_post_status_list() {
    global $post;

    $option_em_revisao = option_helper($post, 'em_revisao', 'Em revisão');
    $option_revisado = option_helper($post, 'revisado', 'Revisado');
    $status = get_post_status_object($post->post_status);

    echo '<script>
      jQuery(document).ready(function($) {
        $("select#post_status")
          .append("' . $option_em_revisao . '")
          .append("' . $option_revisado . '");
        $("#post-status-display").text("' . $status->label . '");
       });
    </script>';
  }
  add_action('admin_footer-post.php', 'jc_append_post_status_list');

  /* Admin Custom Table */
  add_filter('manage_artigo_posts_columns', 'bs_event_table_head');
  function bs_event_table_head($defaults) {
    $defaults['authors'] = 'Autores';
    $defaults['status'] = 'Status';
    $defaults['edition'] = 'Edição';
    $defaults['actions'] = 'Ações';
    return $defaults;
  }
  add_action('manage_artigo_posts_custom_column', 'bs_event_table_content', 1, 2);
  function bs_event_table_content($column_name, $post_id) {
    $status = get_post_status($post_id);
    if ($column_name == 'authors') {
      echo get_post_meta($post_id, $column_name, true);
    }

    if ($column_name == 'status') {
      $status = get_post_status_object($status);
      echo $status->label;
    }

    if ($column_name == 'actions') {
      $actions = array();
      if ($status != 'trash') {
        $actions[] = '<a href="' . admin_url('edit.php?post_type=artigo&id=' . $post_id . '&do_action=reject') . '">Rejeitar</a>';
      }
      if ($status != 'publish') {
        $actions[] = '<a href="' . admin_url('edit.php?post_type=artigo&id=' . $post_id . '&do_action=approve') . '">Aprovar</a>';
      }

      echo join($actions, ' | ');
    }

    if ($column_name == 'edition') {
      $edicao = wp_get_post_terms($post_id, 'edicao');
      if (count($edicao) > 0) {
        echo $edicao[0]->name;
      }
    }
  }

  function approve($id) {
    $post = get_post($id);
    $service = new ArtigoService(get_post($id));
    $service->aprovar();
  }

  function reject($id) {
    $post = get_post($id);
    $service = new ArtigoService(get_post($id));
    $service->rejeitar();
  }

  if (isset($_GET['do_action'])) {
    $action = $_GET['do_action'];
    $action($_GET['id']);
  }
}
?>
