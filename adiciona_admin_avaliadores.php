<?php
  $id = isset($_GET['post']) ? $_GET['post'] : NULL;

  add_action('post_submitbox_start', function() {
    if (!current_user_can('editor') && !current_user_can('administrator')) {
      return;
    }

    $id = isset($_GET['post']) ? $_GET['post'] : NULL;

    if ($id != NULL) {
      $revisores = get_post_meta($id, 'revisores'); ?>

      <b>Revisores</b>
      <ul>
        <?php foreach ($revisores as $key => $revisor) { ?>
          <li>
            <a href="<?= get_post_permalink($id) ?>&r=<?= $revisor['token'] ?>" target="_blank">
              <?= $revisor['name'] ?> (<?= $revisor['email'] ?>)
            </a>

          </li>
        <?php } ?>
      </ul>

      <div>
        <a title="Adicionar avaliador" class="button" rel="modal:open" href="#modal-add-revisor">
          <i class="fa fa-share"></i></i> Adicionar Revisor
        </a>
      </div>

      <div id="modal-add-revisor" style="display:none;">
        <h3>Novo Avaliador</h3>
        <div class="container-modal-add-revisor validate">
          <div class="form-field form-required">
            <label for="name">Nome</label>
            <input id="name" data-avaliador="name" placeholder="Nome">
          </div>

          <div class="form-field form-required">
            <label for="email">e-Mail</label>
            <input data-avaliador="email" placeholder="e-Mail" id="email">
          </div>

          <button type="button" id="add-revisor" class="button">Adicionar</button>
        </div>
      </div>

      <?php
        $addAvaliador = isset($_POST['add-revisor']);

        if ($addAvaliador) {
          $revisor = array(
            'name' => $_POST['name'],
            'email' => $_POST['email']
          );

          $service = new ArtigoService(get_post());
          $service->addRevisor($revisor);
        }
      ?>

      <script>
        jQuery(() => {
          jQuery('#add-revisor').on('click', (event) => {
            let payload = jQuery('[data-avaliador]').toArray().reduce((result, input) => {
              let el = jQuery(input);
              result[el.data('avaliador')] = el.val();
              return result;
            }, {'add-revisor': true});

            let isValid = !Object.values(payload).filter(value => !value).length;
            isValid = isValid && payload.email.indexOf('@') >= 0;
            if (!isValid) {
              alert('Preencha todos os dados corretamente.');
              return;
            }

            let button = jQuery('#add-revisor');
            button.attr('disabled', true);
            button.text('Enviando...');

            jQuery('body').css('cursor', 'progress');
            jQuery.post(window.location.href, payload).done(() => {
              location.reload();
            }).fail((error) => {
              button.removeAttr('disabled');
              button.text('Adicionar');
              jQuery('body').css('cursor', 'default');
              console.error('Falha ao enviar os dados', error);
              alert('Falha ao enviar os dados');
            })
          });
        });
      </script>
<?php }}); ?>
