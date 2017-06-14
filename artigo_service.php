<?php
  class ArtigoService {
    function __construct($post) {
      $this->post = $post;
    }

    function addRevisor($revisor) {
      // Adiciona revisor
      add_post_meta($this->post->ID, 'revisores', $revisor);

      $this->enviarEmailRevisor($revisor);

      $this->alterarStatus('em_revisao');
    }

    function gravarAvaliacao($avaliacao) {
      $dateTime = new \DateTime();
      $_POST['created_at'] = $dateTime->format('c');
      add_post_meta($post->ID, 'avaliacoes', $_POST);
      $this->alterarStatus('revisado');

      // TODO: Enviar e-mail para autor/editor
    }

    public function aprovar() {
      $this->alterarStatus('publish');

      // TODO: Enviar e-mail para autor
    }

    public function rejeitar() {
      $this->alterarStatus('trash');

      // TODO: Enviar e-mail para autor
    }

    private function alterarStatus($status) {
      global $wpdb;
      $wpdb->update($wpdb->posts, array('post_status' => $status), array('ID' => $this->post->ID));
      clean_post_cache($post->ID);
      wp_transition_post_status($status, $this->post->post_status, $this->post);
    }

    private function enviarEmailRevisor($revisor) {
      function wpdocs_set_html_mail_content_type() {
        return 'text/html';
      }

      add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
      $link = get_post_permalink($this->post->ID). '&r=' . $revisor['token'];
      $link = "<a href=\"{$link}\">{$link}</a>";
      $subject = 'Convite para editar ' . get_option('blogname');
      $email = "<h2>Olá, {$revisor['name']}. Você foi indicado para avaliar o artigo {$post->post_title}</h2>.";
      $email .= "<p>Você pode acessar o artigo através do link: {$link}</p>";
      $email .= '<p>Para mais informações acesse: <a href="' . get_site_url() . '">' . get_site_url() . '</a></p>';

      $result = wp_mail($revisor['email'], $subject, $email);
    }
  }
?>