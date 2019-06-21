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
 * 截取utf8字符串,完美支持中文
 * @param string $str 截取的字符串
 * @param int $len 截取长度
 * @param int $from 从那个位置开始截取
 * @param string $adddot 截取后用什么填充 默认...
 * @return mixed|string
 */

function substring($str, $len, $adddot = '...', $from = 0) {
    if ($adddot && mb_strlen($str, 'utf-8') > intval($len)) {
        return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s', '$1', $str) . "..";
    } else {
        return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s', '$1', $str);
    }
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
function redirect($url){
    header('Location: ' . $url);
    edie();
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
    $attach = CF('ATTACHMENT_UPLOAD');
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
        $attach = CF('ATTACHMENT_UPLOAD');
        $image = new \WyPhp\Image();
        $dir = ROOT.'/'.$attach['rootPath'];
        $oldfile = $dir . $info['savepath'].'/'.$info['savename'];
        $smallimg = $dir.$info['savepath'].'/'.'small_'.$info['savename'];
        $image->open($oldfile);
        $image->thumb(300,300,1);    //按比例缩小
        if($image->save($smallimg)){
            return ( array('status' => 1, 'msg' => "图片上传成功",'path'=>$info['savepath'].'/'.'small_'.$info['savename'].CF('IMG_SEVERS'), 'url' =>picSize($info['savepath'].'/'.'small_'.$info['savename'].CF('IMG_SEVERS'))));
        }
        return ( array('status' => 0, 'msg' => "图片上传失败", 'url' => ''));
    }
}

/**
 * @param $string
 * @param string $size ='200x200_1_2'    1裁剪方式，2，水印位置
 * @param string $original 是否原图
 * @return string
 */
function picSize($str, $size = '',$original=false) {
    if (empty($str)) {
        return '';
    }
    $arr = explode('#', $str);
    $imgdomArr = CF('DOMAIN.attach');
    $skey = isset($arr[1]) ?  $arr[1] : 'img1';
    $domain = $imgdomArr[$skey]['url'];
    if($size){
        list($path, $ext) = explode('.', $arr[0]);
        return $domain.'/'.($original ? str_replace('small_','', $path) : $path).'_'.$size.'.'.$ext;
    }
    return $domain.'/'. ($original ? str_replace('small_','', $arr[0]) : $arr[0]);
}
/**
 * 产生随机数
 * @param int|产生随机数长度 $length 产生随机数长度
 * @param int|返回字符串类型 $type 返回字符串类型
 * @param bool|是否去除0 $noO 是否去除0
 * @param string|是否由前缀 $hash 是否由前缀，默认为空. 如:$hash = 'zz-'  结果zz-823klis
 * @return 随机字符串 $type = 0：数字+字母
 */
function random($length =6, $type = 0,$noO = false, $hash = '') {
    if ($type == 0) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    } else if ($type == 1) {
        $chars = '0123456789';
    } else if ($type == 2) {
        $chars = 'abcdefghijklmnopqrstuvwxyz';
    } elseif ($type == 3) {
        $chars = '0123456789abcdefghijkmnpqrstuvwxyz';
    } elseif ($type == 4) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    }
    $noO and $chars = str_replace('0','', $chars);
    $max = strlen($chars) - 1;
    mt_srand((double) microtime() * 1000000);
    for ($i = 0; $i < $length; $i ++) {
        $hash .= $chars [mt_rand(0, $max)];
    }
    return $hash;
}
/**
 * 加密与解密字串
 * @param array $value 要加解密字符串
 * @param $operation  ENCODE 加密，
 * @param $skey 加密串
 * @return string
 */
function mcrypt($value, $operation = 'ENCODE', $skey = '',$expiry=0) {
    if (empty($value)) return false;
    $str ='';
    $en_type = ucfirst(CF('ENCRYPT'));
    $class = '\\WyPhp\\Encrypt\\'.$en_type;
    $mode = new $class($skey, $expiry);
    return $operation == 'ENCODE' ? $mode->encrypt($value) : $mode->decrypt($value);
}
/**
 * 二位数据排序
 * @param $arrays
 * @param $sort_key
 * @param int $sort_order
 * @param int $sort_type
 * @return array|bool
 */
function my_sort($arrays, $sort_key, $sort_order=SORT_ASC, $sort_type=SORT_NUMERIC ){//SORT_DESC
    if(is_array($arrays)){
        foreach ($arrays as $array){
            if(is_array($array)){
                $key_arrays[] = $array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
    return $arrays;
}
/**
 * 创建目录
 * @param $path  创建的目录的名称
 * @param int $mode 规定权限
 * @param bool $recursive 是否设置递归模式
 */
function cmkdir($path, $mode=0775, $recursive =true){
    if (!is_dir($path)) {
        mkdir($path, $mode, $recursive);
    }
}
/**
 * 判断是否SSL协议
 * @return boolean
 */
function is_ssl() {
    if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
        return true;
    }elseif(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function getIP($type = false,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}
/**
 * @param string $key
 * @param string $value
 * @param null $type  存储类型
 * @return bool|null
 */
function session($key='', $value='', $type=NULL,$options=[]){
    if(!$key) return false;
    NEW \WyPhp\Session();
    if(!empty($value) ){
        $_SESSION[$key] = $value;
        return true;
    }
    if($value ===''){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    if($value === null){
        unset($_SESSION[$key]);
    }
}
/**
 * 函数：格式化字节大小
 * @param  number $size 字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = ''){
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) {
        $size /= 1024;
    }
    return round($size, 2) . $delimiter . $units[$i];
}
/**
 * 递归删除缓存信息
 * @param $dirname
 * @return bool
 */
function rmdirr($dirname){
    if (!file_exists($dirname)) {
        return false;
    }
    if (is_file($dirname) || is_link($dirname)) {
        return unlink($dirname);
    }
    $dir = dir($dirname);
    if ($dir) {
        while (false !== $entry = $dir->read()) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            //递归
            rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
        }
    }
    $dir->close();
    return rmdir($dirname);
}

/**
 * 验证手机号是否正确
 * @param $mobile
 * @return bool
 */
function isMobile($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match("/^1[3456789]{1}\d{9}$/",$mobile);
}
/**
 * 生成唯一订单号
 * @return string
 */
function creatOrderId(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).random(3,1);
}
function post($url, $param=array(),$header=array()){
    $httph =curl_init($url);
    curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($httph,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($httph, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);//"Mozilla/5.0 (compatible; MSIE 6.1; Windows NT 5.0)"
    /*if ($param) {
        //$param = is_array($param) ? http_build_query($param) : $param;
        curl_setopt($httph, CURLOPT_POST, 1);//设置为POST方式
        curl_setopt($httph, CURLOPT_POSTFIELDS, $param);
    }*/
    //curl_setopt($httph, CURLOPT_HTTPHEADER, array(
    //        'Content-Type: application/json; charset=utf-8',
    //        'Content-Length: ' . strlen($param),
    //        'Accept: application/json, text/javascript, */*; q=0.01'
    //    )
    //);
    if($param){
        curl_setopt($httph, CURLOPT_POST, 1);//设置为POST方式
        curl_setopt($httph, CURLOPT_POSTFIELDS, $param);
    }
    if($header){
        curl_setopt($httph, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($httph, CURLOPT_CONNECTTIMEOUT , 10);
    curl_setopt($httph, CURLOPT_TIMEOUT, 120);
    curl_setopt($httph, CURLOPT_HEADER, 0);
    $rst = curl_exec($httph);
    if (curl_errno($httph)) {
        curl_close($httph);
        return false;
    }
    curl_close($httph);
    return $rst;
}
/**
 * 产生表单hash值
 * @return bool|string
 */
function formhash(){
    $user = APPbase::$user;
    $uid = isset($user['uid']) ? $user['uid'] : '';
    $hash = isset($user['hash']) ? $user['hash'] : '';
    $skey = 'formhash_'.$uid.$hash;
    $hashCode = S($skey);
    if(empty($hashCode) ){
        $hashCode = random(20);
        S($skey, $hashCode,3600);
    }
    return substr(md5( $hashCode.$hash . $uid  . substr(CF('AUTOKEY'),5,6) ), 8, 20);
}

/**
 * 验证表单hash值
 * @return bool
 */
function check_formhash(){
    $formhash = G('formhash') ? G('formhash') : $_SERVER['HTTP_X_CSRF_TOKEN'];
    $user = APPbase::$user;
    $uid =isset($user['uid']) ? $user['uid'] : '';
    $hash = isset($user['hash']) ? $user['hash'] : '';
    $skey = 'formhash_'.$uid.$hash;
    if($formhash == substr(md5( S($skey).$hash . $uid  . substr(CF('AUTOKEY'),5,6)), 8, 20)){
        return true;
    }
    return false;
}
/**
 * 创建Token
 * @param $TokenId
 * @param string $TokenKey
 * @return string
 */
function creatToken($TokenId=0, $TokenKey = '', $len=15){
    $TokenKey = $TokenKey ? $TokenKey.substr(CF('AUTOKEY'),4,12) : substr(CF('AUTOKEY'),4,12) ;
    return substr(md5($TokenId. $TokenKey),5, $len) ;
}
/**
 * XML编码
 * @param mixed $data 数据
 * @param string $root 根节点名
 * @param string $item 数字索引的子节点名
 * @param string $attr 根节点属性
 * @param string $id   数字索引子节点key转换的属性名
 * @param string $encoding 数据编码
 * @return string
 */
function xml_encode($data, $root='wyphp', $item='item', $attr='', $id='id', $encoding='utf-8') {
    if(is_array($attr)){
        $_attr = array();
        foreach ($attr as $key => $value) {
            $_attr[] = "{$key}=\"{$value}\"";
        }
        $attr = implode(' ', $_attr);
    }
    $attr   = trim($attr);
    $attr   = empty($attr) ? '' : " {$attr}";
    $xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
    $xml   .= "<{$root}{$attr}>";
    $xml   .= data_to_xml($data, $item, $id);
    $xml   .= "</{$root}>";
    return $xml;
}
/**
 * 数据XML编码
 * @param mixed  $data 数据
 * @param string $item 数字索引时的节点名称
 * @param string $id   数字索引key转换为的属性名
 * @return string
 */
function data_to_xml($data, $item='item', $id='id') {
    $xml = $attr = '';
    foreach ($data as $key => $val) {
        if(is_numeric($key)){
            $id && $attr = " {$id}=\"{$key}\"";
            $key  = $item;
        }
        $xml    .=  "<{$key}{$attr}>";
        $xml    .=  (is_array($val) || is_object($val)) ? data_to_xml($val, $item, $id) : $val;
        $xml    .=  "</{$key}>";
    }
    return $xml;
}

/**
 * 获取管理用户名
 * @param $uid
 * @return mixed
 */
function getAdminName($uid){
    $adminModel = D('aceAdmin/Manager');
    $admin_arr = $adminModel->getAdminUser($uid);
    return $admin_arr['user'];
}


/**
 * 获取表单扩展属性
 * @param $id
 * @param $ext_data
 * @return string
 */
function getExtend($id, $ext_data){
   $extend_arr = CF('ARCHIVES_EXT');
   return isset($extend_arr[$id]) ? select_input($extend_arr[$id],$ext_data) : '';
}
function select_input($arr, $ext_data=[]){
    $str = '';
    foreach ($arr as $v){
        switch ($v['type']){
            case 'input':
                $key = trim(str_replace('edata[','', $v['name']),']') ;
                $default = isset($ext_data[$key]) ? $ext_data[$key] : '';
                $class = isset($v['class']) ? $v['class'] : 'col-sm-9';
                $add_but = isset($v['add_but']) ? '<span class="middle" style="margin-left: 15px"><a href="javascript:;" class="add_but">添加</a> <a href="javascript:;" class="del_but">删除</a></span>' : '';

                $str .= '<div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> '.$v['title'].' </label>
                        <div class="'.$class.'">
                            <input type="text" id="form-field-1" name="'.$v['name'].'" value="'.$default.'" placeholder="" class="col-xs-10 col-sm-6">
                            '.$add_but.'
                        </div>
                    </div>';
            break;
            case 'file':
                $key = trim(str_replace('edata[','', $v['name']),'][]') ;
                $default = isset($ext_data[$key]) ? $ext_data[$key] : [];
                $count = $default ? count($default) : 1;
                for ($i=0; $i<$count ;$i++){
                    $str .= '<div class="form-group">
                            <input type="hidden" value="'.$default[$i]['img'].'" name="arrworkslist[]"/>
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> '.$v['title'].'  </label>
                            <div class="col-sm-9">
                                <input data-rel="tooltip" type="text" value="'.$default[$i]['title'].'" name="'.$v['name'].'" id="form-field-6" placeholder="" title="" >
                                
                                <label id="realBtn" class="btn btn-info">
                                <input type="file" id="changfile" name="worksfile[]" class="mFileInput" accept="image/jpg,image/jpeg,image/png,image/bmp" style="left:-9999px;position:absolute;">
                                <span>上传作品</span>
                                </label>
                                <span class="middle showfilename" style="margin-left: 15px"><img src="'.picSize($default[$i]['img']).'" style="max-width: 60px; max-width: 60px"></span>
                                <span class="middle"><a href="javascript:;" class="workslistadd">添加</a> <a href="javascript:;" class="delworks">删除</a></span>
                            </div>
                        </div>';
                }
            break;
            case 'textarea':
                $str .= '';
            break;
        }
    }
    return $str;
}
/**
 * 获取一个类目的顶级类目id
 * @param $id
 * @return mixed
 */
function GetTopid($data, $id){
    static $tree;
    if(empty($data[$id]['pid'])) {
        $tree[] = $data[$id]['name'];
        krsort($tree);
        return $tree;
    } else {
        $tree[] = $data[$id]['name'];
        return GetTopid($data, $data[$id]['pid']);
    }
}
/**
 * 获取前端栏目下所有子栏目
 * @param $data 栏目数据
 * @param $id 栏目id
 * @param int $channel
 * @param bool $addthis 是否包含本身
 * @return string
 */
function GetMenusIds($id, $channel=0, $addthis=true){
    $GLOBALS['idsarrr'] = [];
    $menusModel = D('aceAdmin/Menus');
    $arr = $menusModel->getAll();
    foreach ($arr as $v){
        $tree[$v['typeid']] = $v['pid'];
    }
    GetSonIdsLogic($id,$tree,$channel,$addthis);
    $rquery = join(',',$GLOBALS['idsarrr']);
    return $rquery;
}

/**
 * 获取后台栏目下所有子栏目
 * @param $data 栏目数据
 * @param $id 栏目id
 * @param int $channel
 * @param bool $addthis 是否包含本身
 * @return string
 */
function GetSonIds($id, $channel=0, $addthis=true){
    $GLOBALS['idsarrr'] = [];
    $sidebar = D('aceAdmin/Sidebar');
    $arr = $sidebar->getAll();
    foreach ($arr as $v){
        $tree[$v['id']] = $v['pid'];
    }
    GetSonIdsLogic($id,$tree,$channel,$addthis);
    $rquery = join(',',$GLOBALS['idsarrr']);
    return $rquery;
}

//递归逻辑
function GetSonIdsLogic($id,$sArr,$channel=0,$addthis=true){
    if($id!=0 && $addthis) {
        $GLOBALS['idsarrr'][$id] = $id;
    }
    if(is_array($sArr)) {
        foreach($sArr as $k=>$v) {
            if( $v==$id && ($channel==0)) {
                GetSonIdsLogic($k,$sArr,$channel,true);
            }
        }
    }
}

/**
 * 组装栏目
 * @param $array
 * @return array
 */
function getTree($array,$id = 'id', $pid = 'pid', $son = 'children'){
    $items = $tree = [];
    foreach($array as $value){
        $value['url'] = $value['url'] ? '/'.strtolower(ltrim($value['url'],'/') ) : '';
        $items[$value[$id]] = $value;
    }
    foreach($items as $key => $value){
        if(isset($items[$value[$pid]])){
            $items[$value[$pid]][$son][$key] = &$items[$key];
            $items[$value[$pid]]['acts'][] = $value['url'];
        }else{
            $tree[$key] = &$items[$key];
            $value['url'] && !$value[$pid] and $items[$key]['acts'][] = $value['url'];
        }
    }
    return $tree;
}
/**
 * 判断颠倒图片，放正
 * @param $imgPath   D:\WWW\ayzxweb-admin\Uploads/614cbed662fcaf2e106450a066b44a34579.jpeg
 * @param bool $is_cover  是否覆盖，true覆盖
 */
function imgRotate($imgPath, $is_cover=true){
    if(!function_exists('exif_read_data')){
        return false;
    }
    $exif = exif_read_data($imgPath);
    if(!empty($exif['Orientation'])) {
        $ext = strtolower(end(explode('.', $imgPath))) ;
        if($ext == 'jpeg' || $ext == 'jpg'){
            $image = imagecreatefromjpeg($imgPath);
        }elseif ($ext == 'png'){
            $image = imagecreatefrompng($imgPath);
        }elseif ($ext == 'bmp'){
            $image = imagecreatefromwbmp($imgPath);
        }else{
            $image = imagecreatefromjpeg($imgPath);
        }
        switch($exif['Orientation']) {
            case 8:
                $image = imagerotate($image,90,0);
                break;
            case 3:
                $image = imagerotate($image,180,0);
                break;
            case 6:
                $image = imagerotate($image,-90,0);
                break;
        }
        if(!$is_cover){
            $fileName = end(explode('/',$imgPath));
            $newFileName = md5(time().uniqid()).'.'.$ext;
            $imgPath = str_replace($fileName, $newFileName, $imgPath);
        }
        imagejpeg($image, $imgPath);
        return true;
    }
    return false;
}