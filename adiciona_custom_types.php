<?php

/* Adicionando Custom Type Artigo */

function registrar_artigos()
{
	$descricao = 'Usado para listar os artigos da Revista';
	$singular = ‘Artigo’;
	$plural = ‘Artigos’;

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
		'thumbnail'
	);

	$args = array(
		'labels' => $labels,
		'description' => $descricao,
		'public' => true,
		'menu_icon' => 'dashicons-admin-home',
		'supports' => $supports
	);


	register_post_type( 'artigo', $args);
}

add_action('init', 'registrar_artigos');

?>