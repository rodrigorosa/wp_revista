<?php
  class PostCustomFields {
    function __construct($post) {
      $this->post = $post;
    }

    function toHtml() {
      return
      "{$this->getAuthorsHtml()}
      <section id=\"custom-fields\">
        {$this->getSingleHtml('Resumo','abstract-pt-br')}
        {$this->getSingleHtml('Palavras-chave','keywords')}
        {$this->getSingleHtml('Abstract','abstract-en')}
      </section><hr />";
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
