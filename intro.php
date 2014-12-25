<?php
/**
 * Template Name: intro & contact
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
	
	    if($totle>=1) {
	    	while ($proj_posts->have_posts()){ 
	    		$proj_posts->the_post();
	    		
	    		$intro_nav .= sprintf('<li role="presentation"%s><a href="#tabs%s" aria-controls="tabs%s" role="tab" data-toggle="tab">%s</a></li>', 
	    			( $proj_posts->current_post == 0 ) ? ' class="active"' : '',
	    			$proj_posts->current_post.get_the_ID(),
	    			$proj_posts->current_post.get_the_ID(),
	    			get_the_title()
	    		);

	    		$intro_content .= sprintf('<div role="tabpanel" class="tab-pane%s" id="tabs%s"><div class="container">%s</div></div>',
	    			( $proj_posts->current_post == 0 ) ? ' active' : '',
	    			$proj_posts->current_post.get_the_ID(),
	    			apply_filters('the_content', get_the_content() )
	    		);
	    	}
	    } 
	    wp_reset_postdata();
	?>
	
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<?php echo $intro_nav; ?>
	</ul>

	<div role="tabpanel">
	  <!-- Tab panes -->
	  <div class="tab-content">
	  		<?php echo $intro_content; ?>
	  </div>

	</div>

</div>



<?php get_footer(); ?>

