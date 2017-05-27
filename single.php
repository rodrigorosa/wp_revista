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

        $postRevisao = new PostRevisao($post);
        $finded = NULL;
        if (isset($_GET['r'])) {
          $finded = $postRevisao->getRevisor($_GET['r']);
        }
        ?>

        <?php if ($finded != NULL) { ?>
        <div class="article" style="margin: 5px 80px; background-color: white; padding: 15px;">
          <?php if ($submited) { ?>
            <b>Avaliação submetida com sucesso!!</b>
          <?php } else { ?>
            <h3>Autores</h3>
            <?= get_post_meta(get_post()->ID, 'authors')[0] ?>

            <h3>Resumo</h3>
            <?= get_post_meta(get_post()->ID, 'abstract-pt-br')[0] ?>

            <h3>Abstract</h3>
            <?= get_post_meta(get_post()->ID, 'abstract-en')[0] ?>

            <h3>Keywords</h3>
            <?= get_post_meta(get_post()->ID, 'keywords')[0] ?>

            <h3>Referências</h3>
            <?= get_post_meta(get_post()->ID, 'references')[0] ?>

            <h2>Avaliação</h2>
            <b>Olá <?= $finded['name'] ?></b>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            <form class="" action="" method="post">
              <input type="hidden" name="revisor" value="<?= $finded['token'] ?>">
              <?php foreach ($postRevisao->getCriterios() as $key => $value) { ?>
                <label for="<?= $key ?>"><?= $value ?></label>
                <?php if ($key == 'comentarios') { ?>
                  <br /><textarea name="<?= $key ?>" rows="8" cols="80"></textarea>
                <?php } else { ?>
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <input type="radio" name="<?= $key ?>" value="<?= $i ?>" required> <?= $i ?>
                    <?php } ?>
                <?php } ?>
                <br />
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
