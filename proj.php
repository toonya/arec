<?php
/**
 * Template Name: Project
 *
 */

get_header();
?>

<div class="main">
	<?php  
	    $proj_args = array(
	        'post_type' => 'page',
	        //'lang' => pll_current_language(), // query German and French posts
	        'lang' => 'zh', // query German and French posts
	        //'showposts' => 5,
	        'post_parent' => get_the_ID(),
	    );
	
	    $proj_posts = new WP_Query($proj_args);
	
	    $totle = $proj_posts->found_posts;
	
	    if($totle>=1):;?>
		
			<div class="proj-describe">
				<div class="container">
					<div class="row">
						<?php while ($proj_posts->have_posts()){ $proj_posts->the_post();?>
							<div class="col-xs-4">
								<img class="img-responsive" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large')[0]; ?>" alt="">
								<!-- <div class="d-title"><?php the_title(); ?></div> -->
								<div class="d-content"><?php echo wp_trim_words(get_the_content(), 50, '...<a href="'.get_the_permalink().'" class="pull-right link-button">'.pll__('更多').'</a>' ); ?></div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
	
	    <?php endif;
	
	    wp_reset_postdata();
	?>
</div>



<?php get_footer(); ?>

