<?php
  class PostRevisao {
    const REVISORES_KEY = 'revisores';
    const AVALIACOES_KEY = 'avaliacoes';
    const CRITERIOS = array(
      'ortografia' => 'Ortografia',
      'abnt' => 'ABNT',
      'comentarios' => 'Comentários'
    );

    function __construct($post) {
      $this->post = $post;
    }

    public function revisores() {
      return get_post_meta($this->post->ID, self::REVISORES_KEY);
    }

    public function avaliacoes() {
      return get_post_meta($this->post->ID, self::AVALIACOES_KEY);

      $map = function($item) {
        $parsed = array();

        foreach (self::CRITERIOS as $key => $value) {
          $parsed[$key] = $item['ortografia'];
        };

        return $parsed;
      };

      return array_map($map, $avaliacoes);
    }

    public function getRevisor($token) {
      $finded = NULL;

      foreach ($this->revisores() as $key => $revisor) {
        if ($revisor['token'] == $token) {
          $finded = $revisor;
          break;
        }
      }

      return $finded;
    }

    public function getCriterios() {
      return self::CRITERIOS;
    }

  }

?>
