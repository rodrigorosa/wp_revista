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

		$html = '<ul class="edicao">';
		if ( !empty( $edicoes ) ) {
			foreach($edicoes as $edicao) {
				$image_id = get_term_meta( $edicao->term_id, 'image', true );
				$image_data = wp_get_attachment_image_src( $image_id, 'full' );
				$image = $image_data[0];

				if ( ! empty( $image ) ) {
				    $html .= '<li><a href="' . get_term_link( $edicao, 'edicao' ) . '">' . '<img src="' . esc_url( $image ) . '" />' . '</a></li>';
				}
			}
		}
		$html .= '</ul>';
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

		$html = '<ul class="edicao">';
		if ( !empty( $edicoes ) ) {
			foreach($edicoes as $edicao) {
				$image_id = get_term_meta( $edicao->term_id, 'image', true );
				$image_data = wp_get_attachment_image_src( $image_id, 'full' );
				$image = $image_data[0];

				if ( ! empty( $image ) ) {
				    $html .= '<li><a href="' . get_term_link( $edicao, 'edicao' ) . '">' . '<img src="' . esc_url( $image ) . '" />' . '</a></li>';
				}
			}
		}
    $html .= '</ul>';

		return $html;
	}

	add_shortcode('todas_edicoes', 'get_edicoes');
}

?>
