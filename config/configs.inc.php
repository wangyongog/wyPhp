<?php
return [
    'DEFAULT_DB' =>'hm_',//默认数据库,表前缀区分
    'RW_SEPARATE' =>false, //true 开启,false读写分离是否开启
    'DOMAIN' =>[
        'web' =>'http://www.wyphp.local',//pc主域名
        'adminweb' =>'http://admin.wyphp.local',//后端
        'hzweb' =>'http://newhz.wyphp.local',//后端
        'assets' =>'http://static.wyphp.local',//js+css
        'attach' =>[//上传文件域名,可多服务
            'img1' =>[
                'url' =>'http://i.wyphp.local'
            ],
            'img2' =>[
                'url' =>'http://img.wyphp.local'
            ]
        ]
    ],
    'IMG_SEVERS' =>'#img2',//默认图片服务标识
    'LOAD_CONFIG' =>'menu,task', //扩展配置文件
    'SYSTEM_USERID' => [10000,2], //超级管理员
    'AUTOKEY' =>'ksd%#5$8Yh4dj6JHo42&O)fh4ed9', //秘钥
    'ATTACHMENT_UPLOAD' => [
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 5*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml', //允许上传的文件后缀
        'subName'  => '',
        'rootPath' => 'uploads/', //保存根路径
        'savePath' => 'attaches/'.date('Ymd'), //保存路径
        'saveName' => uniqid(), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
    ], //附件上传配置（文件上传类配置）
    'SESSION_PREFIX' => 's&d#MsP**_', //session前缀
    'COOKIE_PREFIX'  => 'cwy4ywe&ke_', // Cookie前缀 避免冲突
    'SESSION_CACHE'  => '', //dbsession,redis  SESSION缓存类型
    'SESSION_TABLE'  => 'session', //session数据表
    'LIFT_TIME'  => 24*3600, //session,Cookie有效时间
    'COOKIE_DOMAIN' => '.wyphp.local', //session,Cookie作用域
    'COOKIE_HASH'  => false, //session,Cookie是否加密
    'SESSION_ID' =>'session_id',

    'CACHE_TYPE'  => 'Filecache', //   redis,Dbcache,Filecache,memcache缓存类型
    'DATA_CACHE_TABLE'  => 'cache_data', //数据库缓存表名
    'DATA_CACHE_TIME'  => 24*3600, //数据缓时间
    'CACHE_PATH'  => '/data/cachefile', //文件缓存目录
    'ERROR_PATH'  => '/data/logs', //日志目录
    'ERROR_TYPE'  => 'file', //错误记录类型 file,db
    'DEBUG' =>true, //发布后建议false
    'CACHING'  => false, //是否开启模版缓存,发布后建议开启
    'CACHE_HTML' =>'cache/html',
    'URL_HTML_FIX' =>'.html',
    //加密类型
    'ENCRYPT' =>'mcrypt',//openssl
    'URL_DENY_SUFFIX' =>'ico|png|gif|jpg', // URL禁止访问的后缀设置
];