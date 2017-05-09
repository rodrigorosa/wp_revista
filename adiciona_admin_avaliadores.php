<style media="screen">
  #form-add-revisor {
    width: 100%;
    text-align: center;
    input {
      width: 70%;
    }

  }
</style>

<?php

$id = isset($_GET['post']) ? $_GET['post'] : NULL;
add_action('post_submitbox_start', function() {
  $id = isset($_GET['post']) ? $_GET['post'] : NULL;
  if ($id != NULL) {
    add_thickbox();
    $revisores = get_post_meta($id, 'revisores');
    ?>
    <b>Revisores</b>
    <ul>
      <?php foreach ($revisores as $key => $revisor) {
        ?>
        <li>
          <a href="<?= get_post_permalink($id) ?>&r=<?= $revisor['token'] ?>" target="_blank">
            <?= $revisor['name'] ?> (<?= $revisor['email'] ?>)
          </a>

        </li>
      <?php } ?>
    </ul>

    <div>
      <a href="#TB_inline?title=Novo revisor&width=400&height=400&inlineId=modal-add-revisor" class="thickbox">Adicionar revisor</a>
    </div>
<?php }}); php?>

<div id="modal-add-revisor" style="display:none;">
  <h3>Novo revisor</h3>
  <form id="form-add-revisor" action="" method="post">
    <input type="text" name="name" placeholder="Nome" required><br>
    <input type="email" name="email" placeholder="e-Mail" required><br>
    <button type="submit" name="add-revisor" class="button button-primary button-large">Adicionar</button>
  </form>
</div>

<?php
  $addAvaliador = isset($_POST['add-revisor']);

  if ($addAvaliador) {
    $revisor = array(
      'token' => bin2hex(random_bytes(32)),
      'name' => $_POST['name'],
      'email' => $_POST['email']
    );
    add_post_meta($id, 'revisores', $revisor);
  }
?>
