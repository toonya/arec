<?php

add_action( 'admin_menu', 'add_setting' );

function add_setting() {
    add_menu_page( '其它设置', '其它设置', 'manage_options', 'add-setting', 'add_setting_page', '', 110 );
}
function add_setting_page() {
    //setting option
?>

<div id="add-setting" class="admin-page">
    <h1>设置</h1>

    <form action="options.php" method="post">
        <?php
		    settings_fields('add-setting');
		    do_settings_sections('add-setting');
		    submit_button();
        ?>
    </form>
</div>

<?php }
function add_setting_func() {
    // Add the section to reading settings so we can add our
    // fields to it
    add_settings_section('add_setting',
                         '',
                         'add_setting_section',
                         'add-setting');


    //original setting
    // add_settings_field('posts_per_page',
    //                    'posts_per_page',
    //                    'posts_per_page_render',
    //                    'add-setting',
    //                    'add_setting');


    // Add the field with the names and function to use for our new
    // settings, put it in our new section
    add_settings_field('states',
                       '统计代码',
                       'add_setting_stats',
                       'add-setting',
                       'add_setting');
    add_settings_field('slideshow-cn',
                       '中文幻灯片id',
                       'slideshow_cn_builder',
                       'add-setting',
                       'add_setting');
    add_settings_field('slideshow-en',
                       '英文幻灯片id',
                       'slideshow_en_builder',
                       'add-setting',
                       'add_setting');
    add_settings_field('mail-reciver',
                       '接收邮件地址(多个Email使用空格区分)',
                       'mail_reciver_stats',
                       'add-setting',
                       'add_setting');
    // add_settings_field('phone-number',
    //                    '联系电话（填写后，前台会出现相应模块）',
    //                    'phone_number',
    //                    'add-setting',
    //                    'add_setting');

    // add_settings_field('qr-code',
    //                    '微信二维码图片地址（可上传到媒体中心后，复制链接）',
    //                    'qr_code',
    //                    'add-setting',
    //                    'add_setting');
    // add_settings_field('qq-contact',
    //                    'qq联系代码',
    //                    'qq_contact',
    //                    'add-setting',
    //                    'add_setting');

    // add_settings_field('OSS_ACCESS_ID',
    //                    'OSS_ACCESS_ID',
    //                    'oss_access_id',
    //                    'add-setting',
    //                    'add_setting');
    // add_settings_field('OSS_ACCESS_KEY',
    //                    'OSS_ACCESS_KEY',
    //                    'oss_access_key',
    //                    'add-setting',
    //                    'add_setting');
    // add_settings_field('OSS_ACCESS_BUCKET',
    //                    'OSS_ACCESS_BUCKET',
    //                    'oss_access_bucket',
    //                    'add-setting',
    //                    'add_setting');
    // add_settings_field('OSS_ACCESS_DOMAIN',
    //                    'OSS_ACCESS_DOMAIN',
    //                    'oss_access_domain',
    //                    'add-setting',
    //                    'add_setting');



    // Register our setting so that $_POST handling is done for us and
    // our callback function just has to echo the <input>
    // 添加原始的option

    register_setting('add-setting','states');
    register_setting('add-setting','mail-reciver');
    register_setting('add-setting','slideshow-cn');
    register_setting('add-setting','slideshow-en');
    //register_setting('add-setting','phone-number');
    //register_setting('add-setting','qr-code');
    //register_setting('add-setting','qq-contact');

    //register_setting('add-setting','OSS_ACCESS_ID');
    //register_setting('add-setting','OSS_ACCESS_KEY');
    //register_setting('add-setting','OSS_ACCESS_BUCKET');
    //register_setting('add-setting','OSS_ACCESS_DOMAIN');

    //register_setting('add-setting','posts_per_page');

}// eg_settings_api_init()

add_action('admin_init', 'add_setting_func');

function add_setting_section() {
}

function add_setting_stats() {
	echo '<textarea name="states" value="" class="form-control" cols="50" rows="3">'.esc_html(get_option('states')).'</textarea>';
}

function mail_reciver_stats() {
	echo '<textarea name="mail-reciver" value="" class="form-control" cols="50" rows="3">'.esc_attr(get_option('mail-reciver')).'</textarea>';
}

function phone_number() {
  echo '<input name="phone-number" type="text" class="form-control" value="'.esc_attr(get_option('phone-number')).'" />';
}

function slideshow_cn_builder() {
  echo '<input name="slideshow-cn" type="text" class="form-control" value="'.esc_attr(get_option('slideshow-cn')).'" />';
}

function slideshow_en_builder() {
  echo '<input name="slideshow-en" type="text" class="form-control" value="'.esc_attr(get_option('slideshow-en')).'" />';
}

function qr_code() {
  echo '<textarea name="qr-code" value="" class="form-control" cols="50" rows="3">'.esc_attr(get_option('qr-code')).'</textarea>';
}

function qq_contact() {
  echo '<p>多个qq号用空格分隔,例:123 456 789 </p>';
  echo '<textarea name="qq-contact" value="" class="form-control" cols="50" rows="3">'.esc_attr(get_option('qq-contact')).'</textarea>';
}


function oss_access_id() {
  echo '以下区域为可选区域，用于提升网站访问速度。详情请咨询开发人员。<br />';
  echo '<input name="OSS_ACCESS_ID" type="text" class="form-control" value="'.esc_attr(get_option('OSS_ACCESS_ID')).'" />';
}
function oss_access_key() {
  echo '<input name="OSS_ACCESS_KEY" type="text" class="form-control" value="'.esc_attr(get_option('OSS_ACCESS_KEY')).'" />';
}
function oss_access_bucket() {
  echo '<input name="OSS_ACCESS_BUCKET" type="text" class="form-control" value="'.esc_attr(get_option('OSS_ACCESS_BUCKET')).'" />';
}
function oss_access_domain() {
  echo '<input name="OSS_ACCESS_DOMAIN" type="text" class="form-control" value="'.esc_attr(get_option('OSS_ACCESS_DOMAIN')).'" />';
}

function posts_per_page_render() {
  echo '<p>卡片页显示的卡片数量，例如10表示每个卡片页显示10张卡片，多了会出现分页。</p>';
  echo '<p>注意，这里为通用设置，如需单独设置某些地方，请联开发人员。</p>';
  echo '<input name="posts_per_page" type="text" class="form-control" value="'.esc_attr(get_option('posts_per_page')).'" />';
}

?>