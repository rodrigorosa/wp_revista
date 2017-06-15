<?php
/*
  Shortcode para exibir formulário de avaliação
*/

if (!function_exists('formularioAvaliacao')) {

  function selectAvaliacao($name, $options) {
    return "<select required name=\"$name\">
      <option value=\"\">Selecione</option>
      <option value=\"2\">Satisfatório</option>
      <option value=\"1\">Regular</option>
      <option value=\"0\">Insatisfatório</option>
    </select>";
  }

  function text($name, $options) {
    return "<textarea name=\"{$name}\"></textarea>";
  }

  function selectRecomendacao($name, $options) {
    return "<select required name=\"$name\">
      <option value=\"\">Selecione</option>
      <option value=\"2\">Aprovado</option>
      <option value=\"1\">Aprovado com reparos</option>
      <option value=\"0\">Reprovado</option>
    </select>";
  }

  function formularioAvaliacao($atts) {
    $postRevisao = createPostRevisao();
    $revisor = $postRevisao->getRevisor($_GET['r']);
    if ($revisor == NULL) {
      return;
    }

    if (isSubmitted()) {
      return gravarAvaliacao($revisor);
    }

    return formularioAvaliacaoHtml($revisor, $atts);
  }

  function gravarAvaliacao($revisor) {
    global $post;

    $service = new ArtigoService($post);
    $service->gravarAvaliacao($_POST);

    return '<p class="avaliacao-success">Avaliação submetida com sucesso!</p>';

  }

	function formularioAvaliacaoHtml($revisor, $atts) {
    $html = '<h4>Formulário de avaliação</h4>';
    $html = "<form method=\"POST\" class=\"form-submit-avaliacao\">
              <input type=\"hidden\" name=\"revisor\" value=\"{$_GET['r']}\">
              <input type=\"hidden\" name=\"action\" value=\"submit-avaliacao\">
              <div class=\"form-group\">";

    foreach (PostRevisao::CRITERIOS as $name => $options) {
      $html .= "<div class=\"form-group\">
        <label for=\"$name\">{$options['label']}</label>
        {$options['type']($name, $options)}
      </div>";
    }

    $html .= '<div class="form-submit">
      <button class="button" type="submit" value="submit-avaliacao">Submeter</button>
    </div>';
    $html .= '</div></form>';

    return $html;
  }

  function isSubmitted() {
    return isset($_POST['action']) && $_POST['action'] == 'submit-avaliacao';

  }

  function createPostRevisao() {
    global $post;
    return new PostRevisao($post);
  }

  function avaliador($atts) {
    $revisor = createPostRevisao()->getRevisor($_GET['r']);
    return $revisor[$atts['att']];
  }

  function podeAvaliar($atts, $content) {
    $revisor = createPostRevisao()->getRevisor($_GET['r']);
    if (!isSubmitted() && $revisor != NULL) {
      return do_shortcode($content);
    }

    if (isSubmitted() && $revisor != NULL) {
      return gravarAvaliacao($revisor);
    }
  }

	add_shortcode('formulario_avaliacao', 'formularioAvaliacao');
  add_shortcode('avaliador', 'avaliador');
  add_shortcode('pode_avaliar', 'podeAvaliar');
  add_filter('widget_text','do_shortcode');
}

?>
