<section class="one">
	<div class="container">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-3">
				<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="">
			</div>
			<div class="col-sm-7">
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>