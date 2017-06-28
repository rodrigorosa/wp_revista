<?php

function prfx_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
   $prfx_stored_meta = get_post_meta( $post->ID );
   ?>
   <div class="meta-box-artigo">
     <p>
       <label for="authors" class="prfx-row-title"><?php _e( 'Autores', 'prfx-textdomain' )?></label>
       <input class="form-input" type="text" name="authors" id="authors" value="<?php if ( isset ( $prfx_stored_meta['authors'] ) ) echo $prfx_stored_meta['authors'][0]; ?>" />
     </p>

     <p>
       <label for="abstract-pt-br" class="prfx-row-title"><?php _e( 'Resumo', 'prfx-textdomain' )?></label>
       <textarea rows="5" name="abstract-pt-br" id="abstract-pt-br"><?php if ( isset ( $prfx_stored_meta['abstract-pt-br'] ) ) echo $prfx_stored_meta['abstract-pt-br'][0]; ?></textarea>
     </p>

     <p>
       <label for="abstract-en" class="prfx-row-title"><?php _e( 'Abstract', 'prfx-textdomain' )?></label>
       <textarea rows="5" name="abstract-en" id="abstract-en"><?php if ( isset ( $prfx_stored_meta['abstract-en'] ) ) echo $prfx_stored_meta['abstract-en'][0]; ?></textarea>
     </p>

     <p>
       <label for="keywords" class="prfx-row-title"><?php _e( 'Keywords', 'prfx-textdomain' )?></label>
       <input type="text" name="keywords" id="keywords" value="<?php if ( isset ( $prfx_stored_meta['keywords'] ) ) echo $prfx_stored_meta['keywords'][0]; ?>" />
     </p>

     <p>
       <div class="usp_text-editor">
         <label for="references">Referências</label>
         <?php $usp_rte_settings = array(
               'wpautop'          => true,  // enable rich text editor
               'media_buttons'    => true,  // enable add media button
               'textarea_name'    => 'references', // name
               'textarea_rows'    => '10',  // number of textarea rows
               'tabindex'         => '',    // tabindex
               'editor_css'       => '',    // extra CSS
               'editor_class'     => 'usp-rich-textarea', // class
               'teeny'            => false, // output minimal editor config
               'dfw'              => false, // replace fullscreen with DFW
               'tinymce'          => true,  // enable TinyMCE
               'quicktags'        => true,  // enable quicktags
               'drag_drop_upload' => true,  // enable drag-drop
           );
           wp_editor(isset($prfx_stored_meta['references']) ? $prfx_stored_meta['references'][0] : '', 'references', apply_filters('usp_editor_settings', $usp_rte_settings)); ?>
       </div>
     </p>
  </div>
   <?php
}
function wpdocs_register_meta_boxes() {
  add_meta_box( 'meta-box-id', __( 'Revista', 'textdomain' ), 'prfx_meta_callback', 'artigo' );
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
      return;
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'authors' ] ) ) {
    update_post_meta( $post_id, 'authors', sanitize_text_field( $_POST[ 'authors' ] ) );
  }
  if( isset( $_POST[ 'abstract-pt-br' ] ) ) {
    update_post_meta( $post_id, 'abstract-pt-br', sanitize_text_field( $_POST[ 'abstract-pt-br' ] ) );
  }
  if( isset( $_POST[ 'abstract-en' ] ) ) {
    update_post_meta( $post_id, 'abstract-en', sanitize_text_field( $_POST[ 'abstract-en' ] ) );
  }
  if( isset( $_POST[ 'keywords' ] ) ) {
    update_post_meta( $post_id, 'keywords', sanitize_text_field( $_POST[ 'keywords' ] ) );
  }
  if( isset( $_POST[ 'references' ] ) ) {
    update_post_meta( $post_id, 'references', $_POST[ 'references' ] );
  }
}
add_action( 'save_post', 'prfx_meta_save' );


?>
