<?php
return [
    'hm_' =>[
        'master' =>'host:127.0.0.1,port:3306,user:root,database:chinawy_web,password:root,charset:utf8mb4,dbtype:mysql,prefix:nf_',
        'slave' =>'host:192.168.2.166,port:3306,user:leku008,database:aiyihema,password:123456,charset:utf8mb4,dbtype:mysql,prefix:dede_'
    ],
    'mongo_' =>[
        'master' =>'host:192.168.2.166,port:27017,user:leku008,database:mydb,password:123456,dbtype:mongo,prefix:hm_'
    ]
];

