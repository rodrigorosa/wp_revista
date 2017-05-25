<?php
  class PostRevisao {
    const REVISORES_KEY = 'revisores';

    function __construct($post) {
      $this->post = $post;
    }

    public function revisores() {
      return get_post_meta($this->post->ID, self::REVISORES_KEY);
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

  }

?>
