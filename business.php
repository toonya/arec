<?php
/**
 * Template Name: Business
 *
 */

get_header();
?>

<div class="main">
	<?php  
	    $business_args = array(
	        'post_type' => 'page',
	        'lang' => pll_current_language(), // query German and French posts
	        //'showposts' => 5,
	        'post_parent' => get_the_ID(),
	        'orderby' => 'menu_order',
	        'order' => 'asc',
	    );
	
	    $business_posts = new WP_Query($business_args);
	
	    $totle = $business_posts->found_posts;
	
	    if($totle>=1):;?>
		
			<div class="business-describe">
				<div class="container">
					<div class="row">
						<?php while ($business_posts->have_posts()){ $business_posts->the_post();?>
							<div class="col-xs-4">
								<a href="<?php the_permalink(); ?>">
									<div class="img-wrapper">
										<img class="img-responsive" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large')[0]; ?>" alt="">
										<div class="d-title"><?php the_title(); ?></div>
									</div>
									<div class="d-content">
										<?php 
											//echo wp_trim_words(get_the_content(), 50, '...'); 
											the_content();
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

	<div class="container">
		<div class="b-contact">
			<h5><?php echo pll_translate_string('非洲房产有限公司', 'en'); ?></h5>
			<?php echo pll_translate_string('此处填写联系信息', 'en'); ?>
		</div>
	</div>

	
</div>



<?php get_footer(); ?>

