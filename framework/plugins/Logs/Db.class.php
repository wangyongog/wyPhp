<?php
namespace WyPhp\Logs;
/*CREATE TABLE `log_error` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `ltype` VARCHAR(50) NOT NULL DEFAULT '',
    `url` VARCHAR(350) NOT NULL DEFAULT '',
    `msg` TEXT NOT NULL,
    `error` VARCHAR(50) NOT NULL DEFAULT '',
    `addtime` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=3
;*/
class Db{
    public function write($message='', $type='file'){
        $data['ltype'] = $type;
        $data['url'] = ( is_ssl() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/'.CONTROLLER.'/'.ACTION;
        $data['addtime'] = TIMESTAMP;
        $data['msg'] = $message;
        $data['error'] = '';
        \WyPhp\DB::insert('error', $data, false,['prefix' =>'log_']);
    }
}
