<?php

if ( !function_exists( 'get_edicoes_publicadas' ) ) {

	/* Adiciona shortcodes para as taxonomias - pure sugar */

	function get_edicoes_publicadas($atts)
	{
		$edicoes = get_terms( array(
			'orderby' => 'data-edicao',
			'taxonomy' => 'edicao',
			'meta_key' => 'status',
			'meta_value' => 'S'
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
			'orderby' => 'data-edicao',
			'taxonomy' => 'edicao'
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