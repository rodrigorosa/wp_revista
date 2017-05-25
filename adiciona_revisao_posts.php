<?php


function set_post_to_publish($posts) {
  // Remove the filter again, otherwise it will be applied to other queries too.
  remove_filter( 'posts_results', array( __CLASS__, 'set_post_to_publish' ), 10 );

  if (empty($posts)) {
    return;
  }

  $post_id = $posts[0]->ID;
  $post_revisao = new PostRevisao($posts[0]);

  $revisor = $post_revisao->getRevisor($_GET['r']);
  if ($revisor != NULL) {
    $posts[0]->post_status = 'publish';
  }

  return $posts;
}

add_filter('posts_results', 'set_post_to_publish', 10, 2);

?>
