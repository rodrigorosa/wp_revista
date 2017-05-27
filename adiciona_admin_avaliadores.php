<?php
  $id = isset($_GET['post']) ? $_GET['post'] : NULL;

  add_action('post_submitbox_start', function() {
    if (!current_user_can('editor') && !current_user_can('administrator')) {
      return;
    }

    $id = isset($_GET['post']) ? $_GET['post'] : NULL;

    if ($id != NULL) {
      add_thickbox();
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
        <a href="#TB_inline?title=Novo revisor&width=400&height=400&inlineId=modal-add-revisor" class="thickbox">Adicionar revisor</a>
      </div>

      <div id="modal-add-revisor" style="display:none;">
        <h3>Novo revisor</h3>
        <input data-avaliador="name" placeholder="Nome"><br>
        <input data-avaliador="email" placeholder="e-Mail"><br>
        <button type="button" id="add-revisor" class="button button-primary button-large">Adicionar</button>
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

          // E-Mail
          function wpdocs_set_html_mail_content_type() {
            return 'text/html';
          }
          add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
          $post = get_post();
          $link = get_post_permalink($id). '&r=' . $revisor['token'];
          $link = "<a href=\"{$link}\">{$link}</a>";
          $subject = 'Convite para editar ' . get_option('blogname');
          $email = "<h2>Olá, {$revisor['name']}. Você foi indicado para avaliar o artigo {$post->post_title}</h2>.";
          $email .= "<p>Você pode acessar o artigo através do link: {$link}</p>";
          $email .= '<p>Para mais informações acesse: <a href="' . get_site_url() . '">' . get_site_url() . '</a></p>';

          $result = wp_mail($revisor['email'], $subject, $email);
        }
      ?>

      <style media="screen">
        #form-add-revisor {
          width: 100%;
          text-align: center;
          input {
            width: 70%;
          }
        }
      </style>

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

            jQuery('body').css('cursor', 'progress');
            jQuery.post(window.location.href, payload).done(() => {
              location.reload();
            }).fail((error) => {
              jQuery('body').css('cursor', 'default');
              console.error('Falha ao enviar os dados', error);
              alert('Falha ao enviar os dados');
            })
          });
        });
      </script>
<?php }}); php?>
