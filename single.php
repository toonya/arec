<?php get_header();?>


<div class="main single-page">
	<div class="container">
		<?php
			while (have_posts()) {			
				the_post();
				?>
				<h1><?php the_title(); ?></h1>		
				<div class="single-content">
					<!-- <div class="time text-right">
						<?php the_date(); ?>
					</div> -->
					<div class="content">
						<?php the_content(); ?>
					</div>
				</div>
	
				<?php
			}
	
			wp_reset_postdata();
		?>
	</div>
</div>



<?php get_footer(); ?>