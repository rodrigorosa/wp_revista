<?php
	if ( !defined('ABSPATH') ){ die(); }

	global $avia_config;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();

	$title  = __('Blog - Latest News', 'avia_framework'); //default blog title
	$t_link = home_url('/');
	$t_sub = "";

	if(avia_get_option('frontpage') && $new = avia_get_option('blogpage'))
	{
		$title 	= get_the_title($new); //if the blog is attached to a page use this title
		$t_link = get_permalink($new);
		$t_sub =  avia_post_meta($new, 'subtitle');
	}

	if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title(array('heading'=>'strong', 'title' => $title, 'link' => $t_link, 'subtitle' => $t_sub));

	do_action( 'ava_after_main_title' );

?>

		<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container template-blog template-single-blog '>

				<main class='content units <?php avia_layout_class( 'content' ); ?> <?php echo avia_blog_class_string(); ?>' <?php avia_markup_helper(array('context' => 'content','post_type'=>'post'));?>>

                    <?php
                    /* Run the loop to output the posts.
                    * If you want to overload this in a child theme then include a file
                    * called loop-index.php and that will be used instead.
                    *
                    */

                        get_template_part( 'includes/loop', 'index' );

                        //show related posts based on tags if there are any
                        get_template_part( 'includes/related-posts');
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
                        <?php } ?><?php
                        //wordpress function that loads the comments template "comments.php"
                        comments_template();

                    ?>

				<!--end content-->
				</main>

				<?php
				$avia_config['currently_viewing'] = "blog";
				//get the sidebar
				get_sidebar();


				?>


			</div><!--end container-->

		</div><!-- close default .container_wrap element -->


<?php get_footer(); ?>
