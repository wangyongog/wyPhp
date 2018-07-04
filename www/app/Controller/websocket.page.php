<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/28
 * Time: 10:10
 */

namespace App\Controller;


use WyPhp\Controller;
use Workerman\Worker;


class websocket extends Controller {
    public function _initialize(){
    }
    public function actionIndex(){
        $this->render();
    }
    public function actionStart(){
        require_once FWPATH . '/plugins/Vendor/Workerman/Autoloader.php';
        // 创建一个Worker监听2346端口，使用websocket协议通讯

        $ws_worker = new Worker("websocket://0.0.0.0:8080");

        // 启动4个进程对外提供服务
        $ws_worker->count = 4;
        Worker::$daemonize = true;
        Worker::$stdoutFile = ROOT.'/webSocket_stdout.log';
        Worker::$logFile = ROOT.'/webSocket_workerman.log';
        /*$ws_worker->onConnect = function($connection) {
    //echo "new connection from ip " . $connection->getRemoteIp() . "\n";
    $connection->onWebSocketConnect = function($connection , $http_header) {
        // 可以在这里判断连接来源是否合法，不合法就关掉连接
        // $_SERVER['HTTP_ORIGIN']标识来自哪个站点的页面发起的websocket链接
        if($_SERVER['HTTP_ORIGIN'] != 'http://chat.workerman.net')
        {
            $connection->close();
        }
        // onWebSocketConnect 里面$_GET $_SERVER是可用的
        // var_dump($_GET, $_SERVER);
    };
};*/
        // 当收到客户端发来的数据后返回hello $data给客户端
        $ws_worker->onMessage = function($connection, $data) {
            // 向客户端发送hello $data
            $connection->send('hello ' . $data);
        };
        // 运行worker
        Worker::runAll();
    }
}