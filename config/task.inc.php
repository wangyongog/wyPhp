<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26
 * Time: 11:20
 */
return [
    'POSITION' =>[
        1 =>'首页Banner',
        2 =>'首页广告',
        3 =>'文章页广告'
    ],
    'TASK_TYPE'=>[
        'task' =>'微信阅读',
        'gaosu'=>'高速通道',
        'dianzan'=>'微信点赞',
        'taocan'=>'自定义阅读',
        'fans'=>'微信关注',
    ],
    'TASK_TYPE1'=>[
        'task' =>'微信阅读',
        'gaosu'=>'高速通道',
        'dianzan'=>'微信点赞',
        'taocan'=>'自定义阅读',
        'fans'=>'微信关注',
    ],
    'TASK_GRADE'=>[
        1 =>'C',
        2 =>'B',
        3 =>'A',
        4 =>'A+'
    ] ,
    'MOSI' => [
        1=>'普通模式',
        2=>'高速模式'
    ],
    'TASK_STATUS'=>['-1'=>'已关闭','0'=>'调度中','1'=>'执行中','2'=>'已完成'],
    'SHOW_LIST'=>[
        'task'=>[
            'tid'=>['title'=>'订单编号','param'=>['tid'],'hidden'=>1],
            'isclose'=>['hidden'=>1],
            'type'=>['hidden'=>1],
            //'oid'=>['title'=>'订单编号','param'=>['tid'],'hidden'=>1],
            //'id'=>['title'=>'订单编号','func'=>'getoid','param'=>['start_time','id'],'width'=>60],
            //'weixin_no'=>['title'=>'公众号','param'=>['weixin_no'],'width'=>80,'url'=>1,'showhead'=>1],
            'title'=>['title'=>'标题','func'=>'urldecode','param'=>['title'],'width'=>120,'url'=>1],
            'url'=>['title'=>'链接','func'=>'html_entity_decode','param'=>['url'],'width'=>100,'showhead'=>1,'hidden'=>1],
            'count'=>['title'=>'任务量','width'=>60],
            //'zanshu'=>['title'=>'赞数','func'=>'get_zanshu','param'=>['count','thumb'],'width'=>50,'showhead'=>1],
            //'kscount'=>['title'=>'开始阅读量/点赞','func'=>'getdz','param'=>['kscount','initlikenum'],'width'=>100,'showhead'=>1],
            //'dqcount'=>['title'=>'当前阅读量/点赞','func'=>'getdz','param'=>['dqcount','finallikenum'],'width'=>100,'showhead'=>1],
            'jindu'=>['title'=>'进度','func'=>'getdzpren','param'=>['kscount','dqcount','count'],'width'=>50],

            'thumb'=>['title'=>'赞比','width'=>50,'showhead'=>1],
            //'speed'=>['title'=>'速度','width'=>50],
            'cost'=>['title'=>'消费<span class="text-red">(¥)</span>','width'=>50],
            'tmoney'=>['title'=>'退回<span class="text-red">(¥)</span>','param'=>['tmoney'],'width'=>50],
            'create_time'=>['title'=>'提交时间','func'=>'date','param'=>['y-m-d H:i:s','start_time'],'width'=>80],
            'mosi'=>['title'=>'模式','func'=>'get_mosi','param'=>['mosi'],'width'=>80],
            //'map'=>['title'=>'平台','func'=>'get_mapstr','param'=>['map'],'width'=>80,'showhead'=>1],
            'username'=>['title'=>'用户名','width'=>50,'showhead'=>1],
            'contont' =>['title'=>'任务备注','width'=>100],
            'remark'=>['title'=>'备注','width'=>220,'showhead'=>1],
            'status_text'=>['title'=>'状态','func'=>'get_task_status','param'=>['status','isclose'],'width'=>70],
            'status'=>['hidden'=>1]
        ],
        'dianzan'=>[
            'tid'=>['title'=>'订单号','param'=>['id'],'hidden'=>1],
            'isclose'=>['hidden'=>1],
            'type'=>['hidden'=>1],
            'weixin_no'=>['title'=>'公众号','param'=>['weixin_no'],'width'=>80,'url'=>1,'hidden'=>1],
            'title'=>['title'=>'标题','func'=>'urldecode','param'=>['title'],'width'=>260,'url'=>1],
            'url'=>['title'=>'链接','width'=>300,'showhead'=>1,'hidden'=>1],
            'count'=>['title'=>'点赞数','width'=>80],
            'jindu'=>['title'=>'进度','func'=>'getdzpren','param'=>['kscount','dqcount','count'],'width'=>80],
            'thumb'=>['title'=>'赞比','width'=>50,'showhead'=>1,'hidden'=>1],
            'cost'=>['title'=>'消费<span class="text-red">(¥)</span>','width'=>80],
            'tmoney'=>['title'=>'退回<span class="text-red">(¥)</span>','param'=>['tmoney'],'width'=>80],
            'create_time'=>['title'=>'提交时间','func'=>'date','param'=>['y-m-d H:i:s','start_time'],'width'=>140],
            //'map'=>['title'=>'平台','func'=>'get_mapstr','param'=>['map'],'width'=>80,'showhead'=>1],
            'username'=>['title'=>'用户名','width'=>50,'showhead'=>1],
            'contont' =>['title'=>'任务备注','width'=>150],
            'remark'=>['title'=>'备注','width'=>80,'showhead'=>1],
            'status_text'=>['title'=>'状态','func'=>'get_task_status','param'=>['status','isclose'],'width'=>70],
            //'remark1'=>['title'=>'客服备注','showhead'=>1,'width'=>80,'func'=>'status_st','param'=>['status','remark1']],
            'status'=>['hidden'=>1]
        ],
        'fans'=>[
            'tid'=>['title'=>'订单号','param'=>['id'],'hidden'=>1],
            'isclose'=>['hidden'=>1],
            'title'=>['title'=>'公众号','width'=>140],
            'count'=>['title'=>'数量','width'=>80],
            'jindu'=>['title'=>'进度','func'=>'getdzpren','param'=>['kscount','dqcount','count'],'width'=>80],
            'thumb'=>['title'=>'赞比','width'=>50,'showhead'=>1,'hidden'=>1],
            'cost'=>['title'=>'消费<span class="text-red">(¥)</span>','width'=>80],
            'tmoney'=>['title'=>'退回<span class="text-red">(¥)</span>','param'=>['tmoney'],'width'=>80],
            'create_time'=>['title'=>'提交时间','func'=>'date','param'=>['y-m-d H:i','start_time'],'width'=>140],
            //'map'=>['title'=>'平台','func'=>'get_mapstr','param'=>['map'],'width'=>80,'showhead'=>1],
            'username'=>['title'=>'用户名','width'=>80,'showhead'=>1],
            'contont' =>['title'=>'任务备注','width'=>260],
            'remark'=>['title'=>'备注','width'=>200,'showhead'=>1],
            'status_text'=>['title'=>'状态','func'=>'get_task_status','param'=>['status','isclose'],'width'=>70],
            'status'=>['hidden'=>1]
        ],
        'taocan'=>[
            'tid'=>['title'=>'订单号','param'=>['id'],'hidden'=>1],
            'isclose'=>['hidden'=>1],
            'title'=>['title'=>'标题','func'=>'urldecode','param'=>['title'],'width'=>150,'url'=>1],
            'url'=>['title'=>'链接','width'=>300,'showhead'=>1],

            'gzhh'=>['title'=>'公众号会话','width'=>100,'func'=>'get_frommsg','param'=>['frommsg','gzhh','count','map']],
            'hyzf'=>['title'=>'好友转发','width'=>100,'func'=>'get_frommsg','param'=>['frommsg','hyzf','count','map']],
            'pyq'=>['title'=>'朋友圈','width'=>100,'func'=>'get_frommsg','param'=>['frommsg','pyq','count','map']],
            'lsxx'=>['title'=>'历史消息','width'=>100,'func'=>'get_frommsg','param'=>['frommsg','lsxx','count','map']],
            //'wz'=>['title'=>'未知','width'=>100,'func'=>'get_frommsg','param'=>['frommsg','wz','count','map']],

            'count'=>['title'=>'数量','width'=>80],
            //'kscount'=>['title'=>'开始阅读量/点赞','func'=>'getdz','param'=>['kscount','initlikenum'],'width'=>100,'showhead'=>1],
            //'dqcount'=>['title'=>'当前阅读量/点赞','func'=>'getdz','param'=>['dqcount','finallikenum'],'width'=>100,'showhead'=>1],

            //'speed'=>['title'=>'速度','width'=>80],
            'cost'=>['title'=>'消费<span class="text-red">(¥)</span>','width'=>80],
            'tmoney'=>['title'=>'退回<span class="text-red">(¥)</span>','param'=>['tmoney'],'width'=>80],
            'create_time'=>['title'=>'提交时间','func'=>'date','param'=>['y-m-d H:i','start_time'],'width'=>120],
            //'map'=>['title'=>'平台','func'=>'get_mapstr','param'=>['map'],'width'=>80,'showhead'=>1],
            'username'=>['title'=>'用户名','width'=>80,'showhead'=>1],
            'contont' =>['title'=>'任务备注','width'=>80],
            //'remark'=>['title'=>'备注','width'=>80,'hidden'=>1],
            'remark1'=>['title'=>'客服备注','showhead'=>1,'width'=>80,'func'=>'status_st','param'=>['status','remark1']],
            'status_text'=>['title'=>'状态','func'=>'get_task_status','param'=>['status','isclose'],'width'=>80],
            'status'=>['hidden'=>1]
        ]
    ]
];