<?php exit;?>
[nf_]
master    =    host:127.0.0.1,port:3306,user:root,database:chinawy_web,password:'root',charset:utf8mb4,dbtype:mysql,prefix:nf_
slave   =    host:127.0.0.1,port:3306,user:root,database:chinawy_web,password:'root',charset:utf8mb4,dbtype:mysql,prefix:nf_
[fi_]
master    =    host:127.0.0.1,port:3306,user:root,database:china6d_finance,password:'root',charset:utf8mb4,dbtype:mysql,prefix:fi_
slave   =    host:192.168.1.1,port:3306,user:root,database:china6d_finance,password:'root',charset:utf8mb4,dbtype:mysql,prefix:fi_
[log_]
master    =    host:127.0.0.1,port:3306,user:root,database:chinawy_log,password:'root',charset:utf8mb4,dbtype:mysql,prefix:log_
slave   =    host:127.0.0.1,port:3306,user:root,database:chinawy_log,password:'root',charset:utf8mb4,dbtype:mysql,prefix:log_