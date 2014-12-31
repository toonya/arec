<?php
/**
 * Template Name: intro 
 * & contact
 *
 */

get_header();
?>

<div class="main intro tab-nav">
	<?php  
	    $proj_args = array(
	        'post_type' => 'page',
	        'lang' => pll_current_language(), // query German and French posts
	        'post_parent' => get_the_ID(),
	        'orderby' => 'menu_order',
	        'order' => 'asc',
	    );
	
	    $proj_posts = new WP_Query($proj_args);
	
	    $totle = $proj_posts->found_posts;
	    $intro_nav = '';
	    $intro_content = '';
		$current = 0;

	    if($totle>=1) {
	    	while ($proj_posts->have_posts()) {
	    		$proj_posts->the_post();

	    		echo '<img class="img-responsive" src="'.wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full')[0].'" alt="">';
	    		
	    		get_template_part('content', 'intro-'.$current);

	    		$current++;
	    	}
	    }
	    
	    wp_reset_postdata();
	?>

</div>


<?php get_footer(); ?>

