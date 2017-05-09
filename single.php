<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );
        $submited = isset($_POST['submit-avaliacao']);
        if ($submited) {
          add_post_meta($post->ID, 'avaliacoes', $_POST);
        }

        $avaliacoes = get_post_meta($post->ID, 'avaliacoes');
        $avaliacao = $avaliacoes[count($avaliacoes) - 1][$_GET['revisor']];

        $finded = NULL;
        if (isset($_GET['r'])) {
          $revisores = get_post_meta($post->ID, 'revisores');
          foreach ($revisores as $key => $revisor) {
            if ($revisor['token'] == $_GET['r']) {
              $finded = $revisor;
              break;
            }
          }
        }
      ?>

      <?php if ($finded != NULL) { ?>
        <div class="article" style="margin: 5px 80px; background-color: white; padding: 15px;">
          <?php if ($submited) { ?>
            <b>Avaliação submetida com sucesso!!</b>
          <?php } else { ?>
            <h2>Avaliação</h2>
            <b>Olá <?= $finded['name'] ?></b>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            <form class="" action="" method="post">
              <input type="hidden" name="revisor" value="<?= $_GET['revisor'] ?>">
              <label for="ortografia">Ortografia</label>
              <?php for ($i = 1; $i <= 5; $i++) { ?>
                <input type="radio" name="ortografia" value="<?= $i ?>" required <?= $avaliacao['ortografia'] == $i ? 'checked' : '' ?>> <?= $i ?>
              <?php } ?>
              <br><br>
              <div style="text-align: right">
                <button type="submit" name="submit-avaliacao">Enviar!</button>
              </div>
            </form>
          <?php } ?>
        </div>
      <?php } ?>
      <?


			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
