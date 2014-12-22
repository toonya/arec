<?php get_header(); ?>


<div class="main page">
	<div class="container">
		<?php
			while (have_posts()) {			
				the_post();
				?>
				<h1><?php the_title(); ?></h1>
				<div class="page-content">
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



<?php get_footer();


// switch (pll_current_language()) {
//     case 'zh':
//         //get_template_part('content-templates/news', 'cn');
//         get_footer('cn');
//         break;
    
//     default:
//         //get_template_part('content-templates/news', 'en');
//         get_footer('en');
//         break;
// }
?>