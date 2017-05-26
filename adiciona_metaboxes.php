<?php

add_action( 'edit_form_after_title', 'add_content_before_editor' );

function add_content_before_editor() {
  if (!current_user_can('editor') && !current_user_can('administrator')) {
    return;
  }

  $post = get_post();
  $postRevisao = new PostRevisao($post);
  $avaliacoes = $postRevisao->avaliacoes();
?>
<h3>Avaliações</h3>
<table class="wp-list-table widefat fixed striped posts">
  <thead>
    <tr>
      <th>Revisor</th>
      <?php foreach ($postRevisao->getCriterios() as $key => $value) { ?>
        <th><?= $value ?></th>
      <?php } ?>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($avaliacoes as $key => $item) { ?>
      <tr>
        <td><?= $postRevisao->getRevisor($item['revisor'])['name'] ?></td>
        <?php foreach ($postRevisao->getCriterios() as $key => $value) { ?>
          <td><?= $item[$key] ?></td>
        <?php } ?>
      </tr>
    <?php } ?>
  </tbody>
</table>

<h3>Abstract</h3>
<?= get_post_meta(get_post()->ID, 'abstract')[0] ?>
<?php
}

?>