<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 one">
                <?php  
                    $footer_one = array(
                        '公司名称' => '非洲房产有限公司',
                        '地址栏，行1' => '北京市朝阳区',
                        '地址栏，行2' => '朝外大街乙6号',
                        '地址栏，行3' => '朝外SOHO A区11层',
                    );

                    foreach ($footer_one as $t_s) {
                        // translation string
                        echo '<p>'.pll__($t_s).'</p>';
                        //if(  !empty(pll__($t_s)) ) echo '<p>'.pll__($t_s).'</p>';
                    }

                ?>                                                                                                                       
            </div>
            <div class="col-md-3 two">
                <?php  
                    $footer_two = array(
                        '咨询电话' => '咨询电话: 400-815-9888',
                        '传真' => '传真: (86 10) 6567-8383',
                        'Email' => 'Email: pr@arecafrica.com',
                    );

                    foreach ($footer_two as $t_s) {
                        // translation string
                        echo '<p>'.pll__($t_s).'</p>';
                        //if(  !empty(pll__($t_s)) ) echo '<p>'.pll__($t_s).'</p>';
                    }

                ?>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <img class="footer-logo" src="<?php echo get_template_directory_uri(); ?>/img/logo-footer.png" alt="">
            </div>
        </div>
    </div>
    <div class="bottom-bar">
        <div class="container">
            <div class="copyright">
                <strong>©</strong> 
                <?php 
                    pll_e('2012 非洲房产 版权所有'); 
                    if( pll_current_language() == 'zh' ) echo ' <span class="beian">京ICP备05014360号</span>';
                ?> 
            </div>
        </div>
    </div>
</footer>

<?php get_template_part( 'footer', 'default' ); ?>