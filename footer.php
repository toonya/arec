<?php  
$footer_tmp_slug = 'content';
if(is_front_page())
    $footer_tmp_slug = 'home';

get_footer($footer_tmp_slug);
?>