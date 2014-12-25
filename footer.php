<?php  
$footer_tmp_slug = 'content';
if(is_page_template( 'h.php' ) )
    $footer_tmp_slug = 'home';

get_footer($footer_tmp_slug);
?>