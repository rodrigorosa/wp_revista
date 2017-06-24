<?php
/**
 * Main PHP file used to for initial calls to wp_revista's classes and functions.
 *
 * @package wp_revista
 */

/*
Plugin Name: WP_Revista
Plugin URI:
Description: A magazine and newspaper manager plugin for WordPress.
Author: PPT
Version: 0.0.1
Author URI:
Tags:
*/


defined( 'ABSPATH' ) or die( 'Nop!' );

function inicializar()
{
  require_once( 'artigo_service.php' );
  require_once( 'post_revisao.php' );
  require_once( 'adiciona_custom_types.php' );
  require_once( 'adiciona_taxonomias.php' );
  require_once( 'adiciona_meta_term_status_edicao.php' );
  require_once( 'adiciona_meta_term_data_edicao.php' );
  require_once( 'adiciona_shortcodes.php' );
  require_once( 'adiciona_css.php' );
  require_once( 'adiciona_admin_avaliadores.php');
  require_once( 'adiciona_revisao_posts.php');
  require_once( 'adiciona_metaboxes.php' );
  require_once( 'post_custom_fields.php' );
  require_once( 'adiciona_shortcodes_avaliacoes.php' );
  require_once( 'adiciona_js.php' );
}

add_action( 'plugins_loaded', 'inicializar', 9999999999 ); //espera todos os plugins serem carregados

?>
