<footer>
    <div class="container">
    	<div class="addr pull-left">
			<?php  
			    $footer_one = array(
			        '地址栏，行1' => '北京市朝阳区',
			        '地址栏，行2' => '朝外大街乙6号',
			        '地址栏，行3' => '朝外SOHO A区11层',
			    );

			    foreach ($footer_one as $t_s) {
			        // translation string
			        pll_e($t_s);
			    }

			?>
    	</div>
        <div class="copyright pull-right">
             <strong>©</strong>
             <?php 
                 pll_e('2012 非洲房产 版权所有'); 
                 if( pll_current_language() == 'zh' ) echo ' <span class="beian">京ICP备05014360号</span>';
             ?>
        </div>
    </div>
</footer>

<?php get_template_part( 'footer', 'default' ); ?>