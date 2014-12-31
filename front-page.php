<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php wp_title(); ?></title>
        <!-- <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/favicon.ico"> -->
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/style.css">

        <?php wp_head()?>
    </head>
    <body class="boot
        <?php 
            if(wp_is_mobile()) echo ' mobile';
            if(is_page_template( 'h.php' )) echo ' home';
            echo ' '.pll_current_language();
        ?>
    ">


    

        <img src="<?php echo get_template_directory_uri(); ?>/img/logo-footer.png" alt="" class="logo1">
        <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="" class="logo2">

        <div class="links">
            <a href="<?php echo get_permalink( get_page_by_title('首页') ); ?>">简体中文</a>
            <a href="<?php echo get_permalink( get_page_by_title('Home') ); ?>">English</a>
            <a href="<?php echo get_permalink( get_page_by_title('Accueil') ); ?>">Français</a>
        </div>

        <a href="#" id="toTheEnd" class="button">>></a>


        


        <div style="display:none;"><?php echo get_option( 'states' );?></div>

        <script src="<?php echo get_template_directory_uri()?>/js/TweenMax.min.js"></script>
        <script>
            var t = new TimelineMax();
            t
            .set('.logo2, .logo1, .text .i', {opacity:0})
            .to('.logo1', 2, {opacity:1})
            .to('.logo2', .5, {opacity:1})
            .set('.logo1', {opacity: 0})
            .to('.logo2', .5, {top: '-=150px', delay: .5})
            .staggerFrom('.links a', 1, { scale: 0, opacity: 0}, .5)

            document.getElementById("toTheEnd").addEventListener("click", function( event ) {
                t.seek();
            }, false);
        </script>


        <script src="http://localhost:1337/livereload.js"></script>
        <?php wp_footer()?>
    </body>
</html>