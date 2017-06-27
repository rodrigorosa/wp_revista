<?php
  class ArtigoService {
    function __construct($post) {
      $this->post = $post;
    }

    function addRevisor($revisor) {
      $revisor['token'] = bin2hex(random_bytes(32));
      // Adiciona revisor
      add_post_meta($this->post->ID, 'revisores', $revisor);

      $this->enviarEmailRevisor($revisor);

      $this->alterarStatus('em_revisao');
    }

    function gravarAvaliacao($avaliacao) {
      $dateTime = new \DateTime();
      $_POST['created_at'] = $dateTime->format('c');
      add_post_meta($this->post->ID, 'avaliacoes', $_POST);
      $this->alterarStatus('revisado');

      $this->enviarEmailAutor('Artigo avaliado', 'Acesse o link para conferir a avaliação do seu artigo.');
      $this->enviarEmailEditores('Artigo avaliado', 'Acesse o link para conferir a avaliação do seu artigo.');
    }

    public function aprovar() {
      $this->alterarStatus('publish');

      $this->enviarEmailAutor('Artigo aprovado', 'Seu artigo foi aprovado para publicação.');
    }

    public function rejeitar() {
      $this->alterarStatus('trash');

      $this->enviarEmailAutor('Artigo rejeitado', 'Seu artigo não foi aprovado para publicação.');
    }

    private function alterarStatus($status) {
      $updatePost = array(
        'ID' => $this->post->ID,
        'post_status' => $status
      );
      wp_update_post($updatePost);
      wp_transition_post_status($status, $this->post->post_status, $this->post);
    }

    private function enviarEmail($to, $subject, $content) {
      if ( !function_exists( 'wpdocs_set_html_mail_content_type' ) ) {
        function wpdocs_set_html_mail_content_type() {
          return 'text/html';
        }
      }
      add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

      // DEBUG para desenvolvimento
      //echo 'Enviando e-mail para ' . $to . ' com assunto ' .  $subject;
      //echo $content;
      return wp_mail($to, $subject, $content);
    }

    private function enviarEmailRevisor($revisor) {
      $link = get_permalink($this->post->ID). '&r=' . $revisor['token'];
      $link = "<a href=\"{$link}\">{$link}</a>";
      $subject = 'Convite para editar ' . get_option('blogname');
      $email = "<h2>Olá, {$revisor['name']}. Você foi indicado para avaliar o artigo {$this->post->post_title}</h2>";
      $email .= "<p>Você pode acessar o artigo através do link: {$link}</p>";
      $email .= '<p>Para mais informações acesse: <a href="' . get_site_url() . '">' . get_site_url() . '</a></p>';

      return $this->enviarEmail($revisor['email'], $subject, $email);
    }

    private function enviarEmailAutor($subject, $message) {
      $nome = get_the_author_meta('first_name', $this->post->post_author) .
                ' ' .
                get_the_author_meta('last_name', $this->post->post_author);

      $link = get_permalink($this->post->ID);
      $link = "<a href=\"{$link}\">{$link}</a>";

      $subject = '[' . get_option('blogname') . '] ' .$subject;

      $email = "<h2>Olá, {$nome}. Informações sobre o seu artigo {$this->post->post_title}</h2>";
      $email .= "<p>Você pode acessar o artigo através do link: {$link}</p>";

      $email .= "<p>{$message}</p>";

      $email .= '<p>Para mais informações acesse: <a href="' . get_site_url() . '">' . get_site_url() . '</a></p>';

      return $this->enviarEmail(get_the_author_meta('email', $this->post->post_author), $subject, $email);
    }

    private function enviarEmailEditores($subject, $message) {
      $users = get_users(array(role__in => array('editor', 'administrator')));
      $emails = array();
      foreach ($users as $user) {
        $emails[] = $user->user_email;
      }

      $link = get_edit_post_link($this->post->ID);
      $link = "<a href=\"{$link}\">{$link}</a>";

      $subject = '[' . get_option('blogname') . '] ' .$subject;

      $email = "<h2>Olá, Editor. Informações sobre o artigo {$this->post->post_title}</h2>";
      $email .= "<p>Você pode acessar o artigo através do link: {$link}</p>";

      $email .= "<p>{$message}</p>";

      $email .= '<p>Para mais informações acesse: <a href="' . get_admin_url() . '">' . get_admin_url() . '</a></p>';


      return $this->enviarEmail($emails, $subject, $email);
    }
  }
?>
