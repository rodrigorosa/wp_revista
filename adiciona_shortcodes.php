<?php

if ( !function_exists( 'get_edicoes_publicadas' ) ) {

	/* Adiciona shortcodes para as taxonomias - pure sugar */

	function get_edicoes_publicadas($atts)
	{
		$edicoes = get_terms( array(
			'taxonomy' => 'edicao',
			'orderby' => 'data-edicao',
			'hide_empty' => false,
			'meta_key' => 'status-edicao',
			'meta_value' => 's'
			));

		$html =  '';
		if ( !empty( $edicoes ) ) {
			foreach($edicoes as $edicao) {
				$html .= '<a href="' . get_term_link( $edicao, 'edicao' ) . '">' . $edicao->name . '</a>';
			}
		}
		return $html;
	}

	add_shortcode('edicoes_publicadas', 'get_edicoes_publicadas');


	function get_edicoes($atts)
	{
		$edicoes = get_terms( array(
			'taxonomy' => 'edicao',
			'hide_empty' => false,
			'orderby' => 'data-edicao'
			));

		$html =  '';
		if ( !empty( $edicoes ) ) {
			foreach($edicoes as $edicao) {
				$html .= '<a href="' . get_term_link( $edicao, 'edicao' ) . '">' . $edicao->name . '</a>';
			}
		}
		return $html;
	}

	add_shortcode('todas_edicoes', 'get_edicoes');
}

?>
