<?php

if ( !function_exists( 'add_data_field' ) ) {
	/* Adicionando metadata data a taxonomia edicao */

	/* Create */
	function add_data_field($taxonomy)
	{
	    ?>

	    <div class="form-field term-data">
	        <label for="data-edicao">Data</label>
	        <input type="date" id="data-edicao" name="data-edicao" >
	    </div>

	    <?php
	}
	add_action( 'edicao_add_form_fields', 'add_data_field', 10, 2 );

	function save_data_meta( $term_id, $tt_id )
	{
		error_log('save_data_meta');
	    if( isset( $_POST['data-edicao'] ) && '' !== $_POST['data-edicao'] ){
	        $data = sanitize_title( $_POST['data-edicao'] );
	        error_log('term_id'. $term_id . 'data ' . $data);
	        add_term_meta( $term_id, 'data-edicao', $data, true );
	    }
	}
	add_action( 'created_edicao', 'save_data_meta', 10, 2 );


	/* Update */
	function edit_data_field( $term, $taxonomy )
	{
	    $data_edicao = get_term_meta( $term->term_id, 'data-edicao', true );
	    ?>

	    <tr class="form-field term-data-wrap">
	    	<th scope="row">
	    		<label for="data-edicao">Data</label>
	    	</th>
	    	<td>
	    		<input name="data-edicao" id="data-edicao" type="date" value="<?php echo $data_edicao; ?>"  />
			    <p class="description">Data da edição</p>
	    	</td>
	    </tr>

	    <?php
	}
	add_action( 'edicao_edit_form_fields', 'edit_data_field', 10, 2 );

	function update_data_meta( $term_id, $tt_id )
	{
	    if( isset( $_POST['data-edicao'] ) && '' !== $_POST['data-edicao'] ){
	        $data = sanitize_title( $_POST['data-edicao'] );
	        update_term_meta( $term_id, 'data-edicao', $data );
	    }
	}
	add_action( 'edited_edicao', 'update_data_meta', 10, 2 );


	/* Adicionando o cabeçalho da tabela de termos */
	function add_data_edicao_column( $columns )
	{
	    $columns['data_edicao'] = 'Data';
	    return $columns;
	}
	add_filter('manage_edit-edicao_columns', 'add_data_edicao_column' );


	/* Adicionando o conteúdo da tabela de termos */
	function add_data_edicao_column_content( $content, $column_name, $term_id )
	{
	    if( $column_name !== 'data_edicao' ) {
	    	return $content;
	    }

	    $term_id = absint( $term_id );
	    $data_edicao = get_term_meta( $term_id, 'data-edicao', true );

	    if( !empty( $data_edicao ) ){
	        $content .= esc_attr(  $data_edicao );
	    }

	    echo date('d/m/Y', strtotime($content));
	}
	add_filter('manage_edicao_custom_column', 'add_data_edicao_column_content', 10, 3 );

	/* Adicionando ordenação no cabeçalho da tabela de termos */
	function add_data_edicao_column_sortable( $sortable )
	{
	    $sortable[ 'data_edicao' ] = 'data_edicao';
	    return $sortable;
	}
	add_filter( 'manage_edit-edicao_sortable_columns', 'add_data_edicao_column_sortable' );
}
?>
