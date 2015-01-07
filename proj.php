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
	        'lang' => pll_current_language(), // query German and French posts
	        //'showposts' => 5,
	        'post_parent' => get_the_ID(),
	        'orderby' => 'menu_order',
	        'order' => 'asc',
	    );
	
	    $proj_posts = new WP_Query($proj_args);
	
	    $totle = $proj_posts->found_posts;
	
	    if($totle>=1):;?>
		
			<div class="proj-describe">
				<div class="container">
					<div class="row">
						<?php while ($proj_posts->have_posts()){ $proj_posts->the_post();?>
							<div class="col-xs-4">
								<a href="<?php the_permalink(); ?>">
									<div class="img-wrapper">
										<img class="img-responsive" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large')[0]; ?>" alt="">
										<div class="d-title"><?php the_title(); ?></div>
									</div>
									<div class="d-content">
										<?php 
											//echo wp_trim_words(get_the_content(), 50, '...'); 
											echo wpautop(get_post_meta( get_the_ID(), 'abstract_content', true ));
										?>
									</div>
								</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
	
	    <?php endif;
	
	    wp_reset_postdata();
	?>

	<?php  
	    $item_args = array(
	        'post_type' => 'proj',
	        //'lang' => pll_current_language(), // query German and French posts
	        //'lang' => 'zh', // query German and French posts
	        //'showposts' => 5,
	    );
	
	    $item_posts = new WP_Query($item_args);
	
	    $totle = $item_posts->found_posts;
	
	    if($totle>=1):;?>
		
			<div class="item-list">
				<div class="container">
					<div class="row js-masonry" data-masonry-options='{"itemSelector": ".item"}'>
						<?php while ($item_posts->have_posts()){ $item_posts->the_post();?>
							<div class="col-xs-6 item">
								<div class="item-wrapper">
									<h2><?php the_title(); ?></h2>
									<div class="item-content"><?php the_content(); ?></div>
								</div>
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

