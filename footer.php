<?php  
$footer_tmp_slug = pll_current_language();
if(is_front_page())
    $footer_tmp_slug .= '-home';

get_footer($footer_tmp_slug);

?>