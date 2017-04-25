<?php

/* Criando a taxonomia Edição */

function criando_taxonomia_edicao()
{
	$singular = 'Edição';
	$plural = 'Edições';

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

	register_taxonomy('edicao', 'artigo', $args);
}
add_action( 'init' , 'criando_taxonomia_edicao' );



/* Adicionando metadata a taxonomia */
/* Create */
function add_status_field($taxonomy)
{
	$todos_status = array(
	    'n' => 'Não Publicado',
	    's' => 'Publicado'
    );

    ?>

    <div class="form-field term-group">
        <label for="status-edicao">Status</label>

		<select class="postform" id="status-edicao" name="status-edicao">
            <?php foreach ($todos_status as $_status_key => $_status) : ?>
                <option value="<?php echo $_status_key; ?>" class=""><?php echo $_status; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php
}
add_action( 'edicao_add_form_fields', 'add_status_field', 10, 2 );

function save_status_edicao_meta( $term_id, $tt_id )
{
	error_log('save_status_edicao_meta');
    if( isset( $_POST['status-edicao'] ) && '' !== $_POST['status-edicao'] ){
        $status = sanitize_title( $_POST['status-edicao'] );
        error_log('term_id'. $term_id . 'status ' . $status);
        add_term_meta( $term_id, 'status-edicao', $status, true );
    }
}
add_action( 'created_edicao', 'save_status_edicao_meta', 10, 2 );


/* Update */
function edit_edicao_field( $term, $taxonomy )
{
	$todos_status = array(
    	'n' => 'Não Publicado',
    	's' => 'Publicado'
    );

    // get current
    $status_edicao = get_term_meta( $term->term_id, 'status-edicao', true );
    ?>

    <tr class="form-field term-group-wrap">
    	<th scope="row"><label for="feature-group">Status</label></th>
    	<td><select class="postform" id="status-edicao" name="status-edicao">

    		<?php foreach( $todos_status as $_status_key => $_status ) : ?>
    			<option value="<?php echo $_status_key; ?>" <?php selected( $status_edicao, $_status_key ); ?> > <?php echo $_status; ?> </option>
    		<?php endforeach; ?>
    	</select></td>
    </tr>

    <?php
}
add_action( 'edicao_edit_form_fields', 'edit_edicao_field', 10, 2 );

function update_status_meta( $term_id, $tt_id )
{
    if( isset( $_POST['status-edicao'] ) && '' !== $_POST['status-edicao'] ){
        $status = sanitize_title( $_POST['status-edicao'] );
        update_term_meta( $term_id, 'status-edicao', $status );
    }
}
add_action( 'edited_edicao', 'update_status_meta', 10, 2 );

?>
