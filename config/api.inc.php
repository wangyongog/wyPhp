<?php
/**
 * 核心方法或第三方类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/9
 * Time: 11:18
 */
return [
    'core' =>[
        ROOT.'/Common/functions.php',
        FWPATH.'/plugins/Common/functions.php'
    ],
    'configs'=>[
        ROOT.'/config/configs.inc.php',
        ROOT.'/config/redis.inc.php',
        ROOT.'/config/rules.inc.php'
    ],
    'db' =>ROOT.'/config/db.inc.php'
];