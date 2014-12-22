<?php
/**
 * Template Name: News
 *
 */

get_header();
?>


<div class="main news">
	<div class="container">
		<h1><?php echo get_the_title(); ?></h1>		
	
		<div class="news-list">
			<?php  
				$news_args = array(
					'post_type' => 'post',
				    'lang' => pll_current_language(), // query German and French posts
				    //'showposts' => 5,
				);
		
				$news_posts = new WP_Query($news_args);
		
				while ($news_posts->have_posts()) {			
					$news_posts->the_post();
					?>
					
					<div class="item row">
						<div class="col-sm-8"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
						<div class="col-sm-4 text-right"> <?php the_date(); ?> </div>
					</div>
		
					<?php
				}
		
				wp_reset_postdata();
			?>
		</div>

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

