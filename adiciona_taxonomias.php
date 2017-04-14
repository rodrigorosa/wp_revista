<?php

/* Criando a taxonomia Edição */

function criando_taxonomia_edicao()
{
	$singular = ‘Edição’;
	$plural = ‘Edições';

	$labels = array(
		'name' => $plural,
		'singular_name' => $singular,
		'view_item' => 'Ver ' . $singular,
		'edit_item' => 'Editar ' . $singular,
		'new_item' => 'Novo ' . $singular,
		'add_new_item' => 'Adicionar novo ' . $singular
		);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'hierarchical' => true
		);

	register_taxonomy(‘edicao’, ‘artigo’, $args);
}

add_action( 'init' , 'criando_taxonomia_edicao’ );


?>