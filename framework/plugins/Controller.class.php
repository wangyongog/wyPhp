<?php
namespace WyPhp;
/**
 * Controller的基类，控制器基类
 */
abstract class Controller extends Template{
    public $outData = [];   // 输出数据
    public $limit = 20;
    public $tvar = []; // 模板变量
    public $page = 1;  //当前页
    public $count = 0; //总数据
    public $inajax = 0; //是否ajax提交
    public $keywords = '';
    public $description = '';
    public $tbody_html = '';
    public $show_num = 5;
    public $totalPage = 0;  //总页数
    public function __construct() {
        Filter::loadGetPost();
        parent::__construct();
        if(method_exists($this,'_initialize')){
            $this->_initialize();
        }
        $this->assign(CF('DOMAIN'));
        $this->inajax = G('inajax','int',0);
        $this->page = max(1, G('page','int',1));
    }

    /**
     * @param array $par
     * @param string $inPath
     * @param string $page_html
     */
    public function pageBar($par=[], $inPath='', $page_html ='') {
        $pars = [];
        if(!empty($_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $pars);
        }
        $inPath = $inPath ? $inPath : CONTROLLER.'/'.ACTION;
        $this->totalPage = ceil($this->count / $this->limit);
        $pagenum = $this->totalPage;
        $i_page = $this->page;
        $page = min($pagenum, $i_page);
        $prepg = $page - 1;
        $nextpg = $page == $pagenum ? 0 : $page + 1;
        $offset = ($page - 1) * $this->limit;
        $startdata = $this->count ? ($offset + 1) : 0;
        $enddata = min($offset + $this->limit, $this->count);
        $rule = '';
        $pars = $par ? array_merge($par, $pars) : $pars;
        $url = U($inPath, $pars);
        $params['totalSize'] = $this->count;
        $params['pageSize'] = $this->limit;
        $pars['page'] = 1;
        $params['first'] = $this->page <=1 ? '' : U($inPath, $pars);

        $pars['page'] = $nextpg;
        $params['nextpg'] = !empty($nextpg) ? U($inPath, $pars) : '';

        $params['nextpg_1'] = $nextpg;
        $params['prepg_1'] = $prepg;
        $pars['page'] = $prepg;
        $params['prepg'] = !empty($prepg) ? U($inPath, $pars) : '';

        $pars['page'] = $pagenum;
        $params['last'] = $i_page == $pagenum ? '' :  U($inPath, $pars) ;
        $params['startdata'] = $startdata;
        $params['enddata'] = $enddata;
        $params['currpage'] = $i_page;
        $params['pagenum'] = $pagenum;
        if ($pagenum > $this->show_num) {
            if ($i_page >= $this->show_num) {
                $params['start'] = (int)($i_page - $this->show_num / 2);
                $params['max'] = $this->show_num;
                if ($pagenum - $params['start'] < $this->show_num) {
                    $params['start'] = $pagenum - $this->show_num;
                }
            } else {
                $params['start'] = 0;
                $params['max'] = $this->show_num;
            }
        } else {
            $params['start'] = 0;
            $params['max'] = $this->show_num;
        }
        for ($i = $params['start']; $i < min(($params['start']+$params['max']),$params['pagenum']); $i++) {
            $params['pages'][$i]['page'] = $i + 1;
            $pars['page'] = $params['pages'][$i]['page'];
            $params['pages'][$i]['url'] = U($inPath, $pars);
        }
        $this->assign('_p',$params);
        $this->totalPage >=2 and $page_str = $this->fetch($page_html ? $page_html : 'public/page/style2.html');
        $this->assign('_page', $page_str);
    }
    /**
     * Ajax返回数据
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
    function printJson($data = null, $type='JSON') {
        $data = !empty($data) ? $data : $this->outData;
        $jcb = G('jsoncallback');
        if($type == 'JSON' && !$jcb){
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode($data);
            edie();
        }
        if ($jcb) {//如果是跨域操作
            header('Content-Type:application/json; charset=utf-8');
            echo $jcb . '(' . json_encode($data) . ');';
            edie();
        }
        if($type == 'xml'){
            // 返回xml格式数据
            header('Content-Type:text/xml; charset=utf-8');
            echo xml_encode($data) ;
            edie();
        }
    }
    /**
     * ajax 动态加载页面内容以及 动态分页执行
     * @param string $pageHtml  分页模版
     */
    public function dynamicOutPrint($pageHtml=''){
        if(IS_AJAX){
            $this->totalPage = ceil($this->count / $this->limit);
            $this->assign('totalPage', $this->totalPage);
            $this->assign('count', $this->count);
            $this->assign('limit', $this->limit);
            if($this->page ==1){
                $page_str = $this->fetch($pageHtml ? $pageHtml : 'public/page/page.html');
                $this->outData['html']['pagin'] = $this->totalPage>1 ? $page_str : '&nbsp;';
            }
            $this->outData['html']['tbody_data'] = $this->tbody_html ? $this->tbody_html : '暂无查询结果！';
            $this->printJson();
        }
        $this->error();
    }
    function nocacheHeader() {
        header('Expires: Thu, 01 Jan 1970 00:00:01 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
    }
    function __destruct(){

    }

    /**
     * @param string $msg
     * @param string $jumpUrl
     */
    public function success($msg='',$url='',$tpl=''){
        $this->dispatchJump($msg, $url, 1,$tpl);
    }

    /**
     * @param string $message
     * @param string $jumpUrl
     */
    public function error($msg='',$url='',$tpl=''){
        $this->dispatchJump($msg, $url,0, $tpl);
    }

    /**
     * @param $message
     * @param int $status
     * @param string $jumpUrl
     */
    private function dispatchJump($msg='',$url, $status, $tpl='') {
        if(IS_AJAX){
            $this->outData['msg'] = $msg;
            $this->outData['url'] = $url;
            $this->outData['status'] = $status;
            $this->printJson();
        }
        $this->assign('msg', $msg);
        $this->assign('url', $url);
        $this->assign('waitSecond',2);
        $tpl = $tpl ? $tpl : 'public/msg.html';
        $this->render($tpl);
        die();
    }
}