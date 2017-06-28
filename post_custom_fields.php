<?php
  class PostCustomFields {
    function __construct($post) {
      $this->post = $post;
    }

    function toHtml() {
      return
      "{$this->getAuthorsHtml()}
      <section id=\"custom-fields\">
        {$this->getAvaliacoes()}
        {$this->getSingleHtml('Resumo','abstract-pt-br')}
        {$this->getSingleHtml('Palavras-chave','keywords')}
        {$this->getSingleHtml('Abstract','abstract-en')}
      </section><hr />";
    }

    private function getAvaliacoes() {
      $euSouSeuDono = $this->post->post_author == get_current_user_id();

      if ($euSouSeuDono && $this->post->post_status == 'publish') {
        return '';
      }

      $html = '<section class="artigo-avaliacoes">';
      $postRevisao = new PostRevisao($this->post);
      $avaliacoes = $postRevisao->avaliacoes();

      if (count($avaliacoes) == 0) {
        return '';
      }

      $html .= '<h3>Avaliações</h3>';
      foreach ($avaliacoes as $key => $item) {
        $html .= '<h5>Avaliação enviada  em ' . formatarData($item['created_at']) . '</h5>';
        $html .= '<ul>';
        foreach ($postRevisao->getCriterios() as $key => $value) {
          $html .= '<li><b>' . $value['label'] . ': ' . '</b>' . PostRevisao::getDescription($value, $item[$key]) . '</li>';
        }

        $html .= '</ul><hr>';
      }

      return $html . '</section>';
    }

    private function getAuthorsHtml() {
      if ($this->isReviewer()) {
        return '';
      }
      $authors = preg_split('/[\,\;]/', $this->getMeta('authors'));

      $html = '<section id="authors"><ul>';
      foreach ($authors as $author) {
        $html .= "<li>{$author}</li>";
      }
      $html .= '</ul></section>';

      return $html;
    }

    public function getSingleHtml($title, $meta) {
      return "<p class=\"meta-info {$meta}\"><b>{$title}: </b>{$this->getMeta($meta)}</p>";
    }

    private function isReviewer() {
      $postRevisao = new PostRevisao($this->post);
      return $postRevisao->getRevisor($_GET['r']) != NULL;
    }

    private function getMeta($meta) {
      return get_post_meta($this->post->ID, $meta)[0];
    }
  }

  function addCustomFields($content) {
    global $post;
    if ($post->post_type != 'artigo') {
      return $content;
    }
    $postCustomFields =  new PostCustomFields($post);
    return $postCustomFields->toHtml() .
      $content .
      '<hr />' .
      $postCustomFields->getSingleHtml('Referências', 'references');
  }
  add_filter('the_content', 'addCustomFields');
?>
