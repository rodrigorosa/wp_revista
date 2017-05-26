<?php

if ( !function_exists( 'add_status_field' ) ) {
	/* Adicionando metadata status a taxonomia edicao */

	/* Create */
	function add_status_field($taxonomy)
	{
		$todos_status = array(
		    'n' => 'Não Publicado',
		    's' => 'Publicado'
	    );

	    ?>

	    <div class="form-field term-status">
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

	function save_status_meta( $term_id, $tt_id )
	{
		error_log('save_status_meta');
	    if( isset( $_POST['status-edicao'] ) && '' !== $_POST['status-edicao'] ){
	        $status = sanitize_title( $_POST['status-edicao'] );
	        error_log('term_id'. $term_id . 'status ' . $status);
	        add_term_meta( $term_id, 'status-edicao', $status, true );
	    }
	}
	add_action( 'created_edicao', 'save_status_meta', 10, 2 );


	/* Update */
	function edit_edicao_field( $term, $taxonomy )
	{
		$todos_status = array(
	    	'n' => 'Não Publicado',
	    	's' => 'Publicado'
	    );

	    $status_edicao = get_term_meta( $term->term_id, 'status-edicao', true );
	    ?>

	    <tr class="form-field term-status-wrap">
	    	<th scope="row">
	    		<label for="status-edicao">Status</label>
	    	</th>
	    	<td>
	    		<select class="postform" id="status-edicao" name="status-edicao">
		    		<?php foreach( $todos_status as $_status_key => $_status ) : ?>
		    			<option value="<?php echo $_status_key; ?>" <?php selected( $status_edicao, $_status_key ); ?> > <?php echo $_status; ?> </option>
		    		<?php endforeach; ?>
	    		</select>
	    		<p class="description">Status da edição (publicada ou não publicada)</p>
	    	</td>
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


	/* Adicionando o cabeçalho da tabela de termos */
	function add_status_edicao_column( $columns )
	{
	    $columns['status_edicao'] = 'Status';
	    return $columns;
	}
	add_filter('manage_edit-edicao_columns', 'add_status_edicao_column' );


	/* Adicionando o conteúdo da tabela de termos */
	function add_status_edicao_column_content( $content, $column_name, $term_id )
	{
	    $todos_status = array(
	    	'n' => 'Não Publicado',
	    	's' => 'Publicado'
	    );

	    if( $column_name !== 'status_edicao' ){
	        return $content;
	    }

	    $term_id = absint( $term_id );
	    $status_edicao = get_term_meta( $term_id, 'status-edicao', true );

	    if( !empty( $status_edicao ) ){
	        $content .= esc_attr( $todos_status[ $status_edicao ] );
	    }

			echo $content;
	}
	add_filter('manage_edicao_custom_column', 'add_status_edicao_column_content', 10, 3 );

	/* Adicionando ordenação no cabeçalho da tabela de termos */
	function add_status_edicao_column_sortable( $sortable )
	{
	    $sortable[ 'status_edicao' ] = 'status_edicao';
	    return $sortable;
	}
	add_filter( 'manage_edit-edicao_sortable_columns', 'add_status_edicao_column_sortable' );

}
?>
