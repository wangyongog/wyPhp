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
    echo $css_js->loadCss_js($path);
}

function edie($msg=''){
    die($msg);
}
function get_task_status($status=0,$isclose=0){
    $str = '';
    switch ($status) {
        case 0:
            $str .= '<span class="label label-sm label-success">';
        break;
        case 1:
            $str .= '<span class="label label-sm label-danger">';
        break;
        case 2:
            $str .= '<span class="label label-sm label-warning">';
        break;
        case -1:
            $str .= '<span class="label label-sm label-info">';
        break;
    }
    return $str. ( $isclose==1 && !in_array($status,[-1,2])  ? '关闭退款中' :  F('TASK_STATUS')[$status]).'</span>';
}
function get_mosi($mosi=1){
    $mosiArr = F('MOSI');
    return isset($mosiArr[$mosi]) ? ($mosi ==2 ? '<span style="color:#F00">'.$mosiArr[$mosi].'</span>' : $mosiArr[$mosi])  : '未知';
}
function getdzpren($kscount=0,$dqcount=0,$count=0,$spren=false){
    $diff = $dqcount - $kscount ;
    if(!$dqcount || $diff <=0){
        return '0%';
    }
    return round(round($diff /$count,2) * 100,2).'%';
    /*if($spren){
        return round(round($diff /$count,2) * 100,2).'%';
    }
    return $dqcount.' - '.$kscount.' = '. round(round($diff /$count,2) * 100,2).'%' ;*/
}
function get_frommsg($frommsg='', $ftype='',$count=0,$map=0){
    $frommsg = unserialize($frommsg);
    return isset($frommsg[$ftype]) ? $frommsg[$ftype] : 0;
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