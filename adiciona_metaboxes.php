<?php

add_action( 'edit_form_after_title', 'add_content_before_editor' );

function formatarData($str) {
  $dateTime = new DateTime($str);
  $dateTime->setTimezone(new DateTimeZone('America/Sao_Paulo'));
  return $dateTime->format('d/m/Y H:i:s');
}

function add_content_before_editor() {
  if (!current_user_can('editor') && !current_user_can('administrator')) {
    return;
  }

  $post = get_post();
  if ($post->post_type != 'artigo') {
    return;
  }

  $postRevisao = new PostRevisao($post);
  $avaliacoes = $postRevisao->avaliacoes();
?>
<?php foreach ($avaliacoes as $key => $item) { ?>
  <h3>Avaliação enviada por <?= $postRevisao->getRevisor($item['revisor'])['name'] ?> em <?= formatarData($item['created_at']) ?></h3>
  <ul>
    <?php foreach ($postRevisao->getCriterios() as $key => $value) { ?>
      <li><b><?= $value['label'] ?>: </b> <?= PostRevisao::getDescription($value, $item[$key]) ?></li>
    <?php } ?>
  </ul>
  <hr>
<?php } ?>

<?php
}

?>
