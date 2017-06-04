<?php
  class PostRevisao {
    const REVISORES_KEY = 'revisores';
    const AVALIACOES_KEY = 'avaliacoes';
    const CRITERIOS = array(
      'relevancia' => array(label => 'Relevância', type => 'selectAvaliacao'),
      'contribuicao' => array(label => 'Contribuição', type => 'selectAvaliacao'),
      'coesao_estrutural' => array(label => 'Coesão Estrutural', type => 'selectAvaliacao'),
      'introducao' => array(label => 'Introdução', type => 'selectAvaliacao'),
      'desenvolvimento' => array(label => 'Desenvolvimento', type => 'selectAvaliacao'),
      'consideracoes_finais' => array(label => 'Considerações Finais', type => 'selectAvaliacao'),
      'abnt' => array(label => 'ABNT', type => 'selectAvaliacao'),
      'recomenda_publicacao' => array(label => 'Recomenda para publicação', type => 'selectRecomendacao'),
      'comentarios' => array(label => 'Comentários', type => 'text'),
    );
    const HUMANIZE_VALUE_SELECT_AVALIACAO = array(
      0 => 'Insatisfatório',
      1 => 'Regular',
      2 => 'Satisfatório',
    );
    const HUMANIZE_VALUE_SELECT_RECOMENDACAO = array(
      0 => 'Reprovado',
      1 => 'Aprovado com reparos',
      2 => 'Aprovado',
    );

    public static function getDescription($criterio, $value) {
      if ($criterio['type'] == 'selectAvaliacao') {
        return self::HUMANIZE_VALUE_SELECT_AVALIACAO[$value];
      }

      if ($criterio['type'] == 'selectRecomendacao') {
        return self::HUMANIZE_VALUE_SELECT_RECOMENDACAO[$value];
      }

      return $value;
    }

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
