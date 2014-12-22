<?php get_header(); ?>

<!-- Modal -->
<div id="carousel-home" class="carousel slide" data-ride="carousel">

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php  
            $hotel_args = array(
                'post_type' => 'hotel',
                //'lang' => pll_current_language(), // query German and French posts
                'lang' => 'zh', // query German and French posts
                //'showposts' => 5,
            );

            $hotel_posts = new WP_Query($hotel_args);

            $totle = $hotel_posts->found_posts;

            while ($hotel_posts->have_posts()) {         
                $hotel_posts->the_post();
                ?>
                <div class="item <?php if($hotel_posts->current_post==0) echo 'active'; ?>">
                    <div class="img-wrapper">
                        <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full')[0]; ?>" alt="...">
                    </div>
                    <div class="carousel-caption black-bg">
                        <div class="advertisement"><?php echo get_post_meta(get_the_ID(), 'hotel_advertisement', true ); ?></div>
                        <h2><?php the_title(); ?></h2>
                        <a class="permalink" href="<?php echo get_permalink();?>">了解更多</a>
                    </div>
                </div>

                <?php
            }

            wp_reset_postdata();
        ?>
    </div>

    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php  
            for($i=0;$i<$totle;$i++) {
                printf('<li data-target="#carousel-home" data-slide-to="%s" %s></li>',
                    $i,
                    ($i==0)? 'class="active"':''
                );
            };
        ?>
    </ol>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>

<?php get_footer();?>