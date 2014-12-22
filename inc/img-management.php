<?php
// ----------------------------------------
// ! add a admin page to edit the banner
//   slide images
// ----------------------------------------

class TY_img_management {
    protected $language;
    protected $language_name;
    protected $img_notice;
    protected $img_list;
    protected $add_new_focus;

    public function __construct($language='', $name='', $img_notice=''){
        $this->language = $language;
        $this->language_name = $name;
        $this->img_list = get_option('ty_imglist'.$this->language);

        if( $img_notice )
            $this->img_notice = $img_notice;
        else
            $this->img_notice = '注意，首页幻灯片图片长宽必须为1680px*550px。';

        if(!$this->img_list)
            $this->add_new_focus = true;
        else
            $this->add_new_focus = false;

        // manage menu & page init
        add_action( 'admin_menu', array(&$this, 'home_imgs') );
        // add ajax support
        add_action( 'admin_enqueue_scripts', array(&$this, 'load_admin_banner_ajax' ));
    }

    public function home_imgs() {
        add_menu_page( $this->language_name.'图片管理', $this->language_name.'图片管理', 'manage_options', 'img_management_'.$this->language, array(&$this, 'img_build'), '' );
    }

    public function img_build() { ?>

        <div id="banner-option">
            <h1><?php echo $this->language_name;?>首页图片管理</h1>
            <p class="text-info banner-img">
                <?php echo $this->img_notice; ?>
            </p>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
            <?php if($this->img_list) {
                foreach($this->img_list as $key=>$item) {
                    $num = $key+1;
                    if($num==1)
                        echo '<li class="active"><a href="#'.$num.'" data-toggle="tab">'.$num.'</a></li>';
                    else
                        echo '<li><a href="#'.$num.'" data-toggle="tab">'.$num.'</a></li>';
                }
            }
        ?>
                <li <?php if($this->add_new_focus) echo'class="active"';?>><a href="#addnew" data-toggle="tab">+</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content container tab-container">
            <?php if($this->img_list) {
                foreach($this->img_list as $key=>$item) {
                    $num = $key+1;
                    $img = $item['imgurl'];
                    $url = $item['url'];
                    $title = $item['title'];
                    $describe = $item['describe'];
                    $year1 = $item['year1'];
                    $rate1 = $item['rate1'];
                    $year2 = $item['year2'];
                    $rate2 = $item['rate2'];
                    ?>

                <div class="tab-pane <?php if($num==1) echo 'active'; ?>" id="<?php echo $num; ?>">
                    <div class="col-sm-11">
                        <!-- input area for store data -->
                        <div class="info">
                            <?php // 添加新的栏目，需要添加上面的foreach, 以及下面addnew那里的表单, 以及js里面的上传表单 ?>
                            <input type="text" value="<?php echo $title; ?>" class="form-control title need" placeholder="输入标题" />
                            <input type="text" value="<?php echo $describe; ?>" class="form-control describe need" placeholder="输入描述" />
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" value="<?php echo $year1; ?>" class="form-control year1 need" placeholder="输入年1" />
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" value="<?php echo $rate1; ?>" class="form-control rate1 need" placeholder="输入率1" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" value="<?php echo $year2; ?>" class="form-control year2 need" placeholder="输入年2" />
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" value="<?php echo $rate2; ?>" class="form-control rate2 need" placeholder="输入率2" />
                                </div>
                            </div>

                            <input type="text" value="<?php echo $url; ?>" class="form-control url" placeholder="输入超链接" />
                            <input type="text" value="<?php echo $img; ?>" class="form-control imgurl need" placeholder="输入图片地址，或点击下面的按钮从图片库中选择" />
                        </div>
                        <!-- control area -->
                        <div class="row control">
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary btn-danger btn-block open-media">选择图片</button>
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-primary btn-block save">保存</button>
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-warning btn-block delete">删除</button>
                            </div>
                            <div class="preview col-sm-9">
                                <img class="img-responsive" src="<?php echo $img; ?>" alt="<?php echo $title; ?>" />
                            </div>
                        </div>
                    </div>
                </div>

                    <?php
                }
            }
            ?>
                <div class="tab-pane <?php if($this->add_new_focus) echo 'active' ?>" id="addnew">
                    <div class="col-sm-11">
                        <!-- input area for store data -->
                        <div class="info">
                            <input type="text" class="form-control title need" placeholder="输入标题" />
                            <input type="text" class="form-control describe need" placeholder="输入描述" />
                            
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" value="" class="form-control year1 need" placeholder="输入年1" />
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" value="" class="form-control rate1 need" placeholder="输入率1" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" value="" class="form-control year2 need" placeholder="输入年2" />
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" value="" class="form-control rate2 need" placeholder="输入率2" />
                                </div>
                            </div>

                            <input type="text" class="form-control url" placeholder="输入超链接" />
                            <input type="text" class="form-control imgurl need"  placeholder="输入图片地址，或点击下面的按钮从图片库中选择" />
                        </div>
                        <!-- control area -->
                        <div class="row control">
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary btn-danger btn-block open-media">选择图片</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary btn-block add">保存</button>
                            </div>
                            <div class="preview col-sm-9">
                                <img src="" class="img-responsive" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php }

    public function load_admin_banner_ajax() {
        $screen = get_current_screen();

        if ( in_array( 'toplevel_page_img_management_'.$this->language, array( $screen->id ) ) )
        {

            wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/inc/css/admin.css' );
            wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
            wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), '1.0.0', true );
            wp_enqueue_script( 'admin-javascript', get_template_directory_uri() . '/inc/js/admin.js', array('jquery'), '1.0.0', true );

            wp_enqueue_script('img-management',get_template_directory_uri().'/inc/js/img-management.js',array('jquery'), '1.0.0', true);

            wp_localize_script( 'img-management', 'banner_option',
                array( 
                    'url' => admin_url( 'admin-ajax.php' ), 
                    'action'=>'ty_save_imgs' , 
                    'language' => $this->language,
                    'security'=>wp_create_nonce('img-management-nonce-'.$this->language), 
                    'baseurl'=> wp_upload_dir()['baseurl'] 
            ));

            wp_enqueue_media();
        }

        else {
            //wp_die( $screen->id );
        }
    }
}

// ----------------------------------------
// ! save
// ----------------------------------------

function ty_save_imgs() {
    //check nonce
    check_ajax_referer('img-management-nonce-'.$_POST['language'], 'security' );

    $results = '';

    $img_list = $_POST['bannerlist'];
    update_option( 'ty_imglist'.$_POST['language'], $img_list );
    $bannerlistval =  get_option('ty_imglist'.$_POST['language']) ;


    if ( $bannerlistval )
    {
        $results = $bannerlistval ;
    }
    else {
        $results = false ;
    }
    // Return the String
    wp_send_json($results);
}
add_action( 'wp_ajax_ty_save_imgs', 'ty_save_imgs');


?>