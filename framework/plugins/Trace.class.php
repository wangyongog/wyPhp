<?php
namespace WyPhp;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/6
 * Time: 11:49
 */
class Trace{
    //导入文件
    protected $included_files;
    //输出信息
    protected $_trace;
    //链接数据库次数
    protected $link_query =0;
    //数据库操作
    protected $exe_query =0;
    /**
     * 显示加载信息
     * @param $detail
     * @return unknown_type
     */
    public function showTrace(){
        $this->included_files = get_included_files();
        $this->link_query = DB::queryTimes();
        $this->exe_query = DB::executeTimes();
        // 系统默认显示信息
        $this->_trace['请求脚本'] = $_SERVER['SCRIPT_NAME'];
        $this->_trace['请求方法'] = CONTROLLER.'/'. ACTION;
        $this->_trace['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        $this->_trace['HTTP版本'] = $_SERVER['SERVER_PROTOCOL'];
        $this->_trace['请求时间'] = date('Y-m-d H:i:s', TIMESTAMP);

        $this->_trace['读取数据库'] = $this->link_query . '次';
        $this->_trace['写入数据库'] = $this->exe_query . '次';
        $this->_trace['加载文件数目'] = count($this->included_files);
        $this->_trace['PHP执行占用'] = $this->getMerTime();
        $request = $requireFlie = '';
        foreach ($this->_trace as $key => $info) {
            $request .= '<p>'.$key . ' : ' . $info .'</p>';
        }

        //输出包含的文件
        foreach ($this->included_files as $file) {
            $requireFlie .= '<p>'.'require ' . $file .'</p>';
        }
        // 调用Trace页面模板
        $html = <<<HTMLS
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <title></title>
        <style type="text/css">
        *{ padding: 0; margin: 0; }
        html{ overflow-y: scroll; }
        body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
        img{ border: 0; }
        .error{ padding: 24px 48px; }
        .face{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        h1{ font-size: 32px; line-height: 48px; }
        .error .content{ padding-top: 10px}
        .error .info{ margin-bottom: 12px; }
        .error .info .title{ margin-bottom: 3px; }
        .error .info .title h3{ color: #000; font-weight: 700; font-size: 16px; }
        .error .info .text{ line-height: 24px; }
        .copyright{ padding: 12px 48px; color: #999; }
        .copyright a{ color: #000; text-decoration: none; }
        </style>
        </head>
        <body>
        <div class="error">
        <p class="face">:(</p>
        <h1>加载信息</h1>
        <div class="content">
        <div class="info">
            <div class="title">
                <h3>请求信息</h3>
            </div>
            <div class="text">
            $request
            </div>
        </div>
        <div class="info">
            <div class="title">
                <h3>加载文件</h3>
            </div>
            <div class="text">
                $requireFlie
            </div>
        </div>
        </div>
        </div>
        </body>
        </html>
HTMLS;
        return $html;
    }
    /**
     * 显示运行时间和内存占用
     *
     * @return string
     */
    public function getMerTime(){
        $runtime = $this->runtime();
        // 显示运行时间
        $showTime = '执行时间: ' . $runtime['time'];
        // 显示内存占用
        $showTime .= ' | 内存占用:' . $runtime['memory'];
        return $showTime;
    }
    /**
     * 获取资源消耗
     * @return array
     */
    public function runtime(){
        // 显示运行时间
        $return['time'] = number_format((microtime(true)-\APPbase::$env['start']),4).'s';
        $startMem = array_sum(explode(' ',\APPbase::$env['mem']));
        $endMem = array_sum(explode(' ',memory_get_usage()));
        $return['memory'] = number_format(($endMem - $startMem)/1024).'kb';
        return $return;
    }
    public function stop(){
        //print_r(debug_backtrace());exit;
    }
}