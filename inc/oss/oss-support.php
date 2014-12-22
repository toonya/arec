<?php

update_option('uploads_use_yearmonth_folders', 0);



add_filter('wp_handle_upload_prefilter', 'custom_upload_filter' );
add_filter('wp_handle_upload', 'oss_upload', 9, 2);

//生成缩略图后立即上传生成的文件
add_filter('wp_update_attachment_metadata', 'upload_images', 10,1);
add_filter('wp_generate_attachment_metadata', 'upload_images', 10,1);

add_filter('wp_get_attachment_url', 'get_oss_media');
add_filter('wp_get_attachment_thumb_url', 'get_oss_media');

//删除远程附件
add_action('wp_delete_file', 'delete_remote_file');


function custom_upload_filter( $file ){

	preg_match('/\.\w*$/',$file['name'] ,$mine);

    $file['name'] = wp_hash( $file['name']).$mine[0] ;

	return $file;
}



function oss_upload($data, $override){

	//$is_image = explode('image', $data['type']);

	//if(count($is_image)<=1) {

		$wp_upload_dir = wp_upload_dir();

		$file_path = $data['file'];

		$object = str_replace($wp_upload_dir['basedir'].'/','',$file_path);

		_file_upload($object,$file_path);
	//}
	return $data;
}


function _format($response) {
	echo '|-----------------------Start---------------------------------------------------------------------------------------------------'."\n";
	echo '|-Status:' . $response->status . "\n";
	echo '|-Body:' ."\n";
	echo $response->body . "\n";
	echo "|-Header:\n";
	print_r ( $response->header );
	echo '-----------------------End-----------------------------------------------------------------------------------------------------'."\n\n";
}


//上传函数
function _file_upload( $object , $file_path , $opt = array()){
	require_once('sdk.class.php');

	//获取WP配置信息
    $bucket = get_option('OSS_ACCESS_BUCKET');

	//实例化存储对象
	if(empty($oss_sdk_service))
		$oss_sdk_service = new ALIOSS();
	//上传原始文件
	$opt['Expires'] = 'access plus 1 years';

	//$object = iconv("gbk","utf-8",$file_path);
	//$file_path = iconv("gbk","utf-8",$file_path);

	try{
		$response = $oss_sdk_service->upload_file_by_file($bucket,$object,$file_path,$opt);
		//_format($response);
	}catch (Exception $ex){
		wp_die($ex->getMessage());
	}

	return $response;
}

/**
 * 上传所有文件到服务器，没有删除本地文件
*  @static
 * @param $metadata from function wp_generate_attachment_metadata
 * @return array
 */
function upload_images($metadata)
{
	//获取上传路径
	$wp_upload_dir = wp_upload_dir();

	if(!empty($metadata)){
		$upload_path = get_option('upload_path');
		if($upload_path == '.' ){
			$upload_path = '';
			$object = $metadata['file'];
		}
		else{
			$upload_path = trim($upload_path,'/');
			$object = ltrim($upload_path.'/'.$metadata['file'],'/');
		}
		//上传原始文件
		$file_path = $wp_upload_dir['basedir'].'/'.$metadata['file'];
		_file_upload ( $object, $file_path);


		//上传小尺寸文件
		if (isset($metadata['sizes']) && count($metadata['sizes']) > 0)
		{
			//there may be duplicated filenames,so ....
			foreach ($metadata['sizes'] as $val)
			{
				$object = ltrim( $upload_path.$wp_upload_dir['subdir'].'/'.$val['file'] , '/' );
				$file_path = $wp_upload_dir['path'].'/'.$val['file'];
				$opt =array('Content-Type' => $val['mime-type']);
				_file_upload ( $object, $file_path, $opt );
			}
		}
	}

	return $metadata;
}

/**
 * 删除远程服务器上的单个文件
 * @static
 * @param $file
 * @return void
 */
function delete_remote_file($file)
{
	require_once('sdk.class.php');

	//获取WP配置信息
    $bucket = get_option('OSS_ACCESS_BUCKET');

	//获取保存路径
	$upload_path = get_option('upload_path');
	if($upload_path == '.' )
		$upload_path='';
	else
		$upload_path = trim($upload_path,'/');

	//获取上传路径
	$wp_upload_dir = wp_upload_dir();

	$file_path = str_replace($wp_upload_dir['basedir'],'',$file);
	$file_path = ltrim( str_replace('./','',$file_path), '/');
	if( $upload_path != '' )
		$file_path = $upload_path .'/'. $file_path;

	//实例化存储对象
	if(empty($oss_sdk_service))
		$oss_sdk_service = new ALIOSS();
	//删除文件
	$oss_sdk_service->delete_object( $bucket, $file_path);

	return $file;
}


function get_oss_media($url) {

	$wp_upload_dir = wp_upload_dir();
	$oss_base_dir = get_option('OSS_ACCESS_DOMAIN');
	$oss_url = str_replace($wp_upload_dir['baseurl'], $oss_base_dir, $url);

	return $oss_url;
}

?>