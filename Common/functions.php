<?php
/**
 * 格式化时间
 * @param $tm
 * @param bool $month
 * @param bool $year
 * @param string $format
 * @return string
 */
function sort_time($tm, $month = false, $year = false, $format = 'Y-m-d') {
    $dottime = TIMESTAMP - $tm;
    $unit = $dottime >= 0 ? '前' : '后';
    $dottime = abs($dottime);
    $str = '';
    if ($dottime < 60) {
        $dottime = max(1, $dottime);
        $str = $dottime . '秒' . $unit;
    } elseif ($dottime < 3600) {
        $str = floor($dottime / 60) . '分钟' . $unit;
    } elseif ($dottime < 86400) {
        $str = round($dottime / 3600) . '小时' . $unit;
    } elseif ($dottime < 2592000) {
        $str = round($dottime / 86400) . '天' . $unit;
    } elseif ($month && $dottime < 31104000) {
        $str = round($dottime / 2592000) . '个月' . $unit;
    } elseif ($year && $dottime < 155520000) {
        $str = round($dottime / 31104000) . '年' . $unit;
    } else {
        $str = date($format, $tm);
    }
    return $str;
}

/**
 * 动态加载css js
 * @param $path
 * @return mixed
 */
function loadCss_js($path = []){
    $css_js = NEW \WyPhp\CssJs();
    return $css_js->loadCss_js($path);
}

function edie($msg=''){
    die($msg);
}
function get_map(){
    $set = D('Admin/Setting');
    $config = $set->get_setting('', 'all');
    $sitenameArr = [];
    if($config){
        foreach ($config as $key=>$val){
            $sitenameArr[$key] = $val['sitename'];
        }
    }
    return $sitenameArr;
}

/**
 * base64格式上传
 * @param string $base64_string
 * @return array
 */
function base64upload($base64_string=''){
    if(!$base64_string){
        return( array('code' => 4, 'msg' => "请上传文件",'status'=>0));
    }
    $base64_img = trim($base64_string);
    $attach = F('ATTACHMENT_UPLOAD');
    $up_dir = ROOT.'/'. $attach['rootPath'].'/'.$attach['savePath'];
    if(!file_exists($up_dir)){
        mkdir($up_dir,0777,true);
    }
    if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
        $type = $result[2];
        if(in_array($type, array('jpeg','jpeg','jpg','gif','bmp','png'))){
            $file_name = rand(0,999).md5(TIMESTAMP.$attach['saveName']).'.'.$type;
            $new_file = $up_dir.'/'.$file_name;
            if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))){
                $image = new \WyPhp\Image();
                $smallimg = $up_dir.'/small_'.$file_name;     //拼缩图名
                $image->open($new_file);
                $image->thumb(300,300,1);    //按比例缩小
                if($image->save($smallimg)){
                    return ( array('code' => 1, 'msg' => "图片上传成功", 'url' => $smallimg));
                }
                return ( array('code' => 0, 'msg' => "图片上传失败", 'url' => ''));
            }
            return ( array('code' => 2, 'msg' => "图片上传失败",'status'=>0));
        }

        return( array('code' => 4, 'msg' => "文件类型错误",'status'=>0));
    }
    return(array('code' => 3, 'msg' => "文件错误",'status'=>0)) ;
}


/**
 *
 * @param $file
 * @return array
 */
function upload($file){
    $upload = new \WyPhp\Upload();// 实例化上传类
    $info = $upload->upload($file);
    if(!$info) {// 上传错误提示错误信息
        return ['msg' =>$upload->getError(),'status'=>0];
    }else{// 上传成功 获取上传文件信息
        $attach = F('ATTACHMENT_UPLOAD');
        $image = new \WyPhp\Image();
        $dir = ROOT.'/'.$attach['rootPath'];
        $oldfile = $dir . $info['savepath'].'/'.$info['savename'];
        $smallimg = $dir.$info['savepath'].'/'.'small_'.$info['savename'];
        $image->open($oldfile);
        $image->thumb(300,300,1);    //按比例缩小
        if($image->save($smallimg)){
            return ( array('status' => 1, 'msg' => "图片上传成功",'path'=>$info['savepath'].'/'.'small_'.$info['savename'], 'url' =>picSize($info['savepath'].'/'.'small_'.$info['savename'])));
        }
        return ( array('status' => 0, 'msg' => "图片上传失败", 'url' => ''));
    }
}

/**
 * @param $string
 * @param string $size ='200x200_1_2'    1裁剪方式，2，水印位置
 * @return string
 */
function picSize($str, $size = '') {
    if (empty($str)) {
        return '';
    }
    $arr = explode('#', $str);
    $imgdomArr = F('DOMAIN/attach');
    $skey = isset($arr[1]) ?  $arr[1] : 'img1';
    $domain = $imgdomArr[$skey]['url'];
    if($size){
        list($path, $ext) = explode('.', $str);
        return $domain.'/'.$path.'_'.$size.'.'.$ext;
    }
    return $domain.'/'.$str;
}