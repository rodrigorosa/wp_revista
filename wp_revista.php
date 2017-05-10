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


function inicializar()
{
	require_once( 'adiciona_custom_types.php' );
	require_once( 'adiciona_taxonomias.php' );
	require_once( 'adiciona_meta_term_status_edicao.php' );
	require_once( 'adiciona_meta_term_data_edicao.php' );
	require_once( 'adiciona_shortcodes.php' );
	require_once( 'adiciona_avaliacoes' );
	require_once( 'adiciona_admin_avaliadores');
}
add_action( 'plugins_loaded', 'inicializar', 9999999999 ); //espera todos os plugins serem carregados

?>
