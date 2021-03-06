<?php
namespace WyPhp;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/22
 * Time: 17:15
 */
class Model {
    // 操作状态
    const MODEL_INSERT = 1;      //  插入模型数据
    const MODEL_UPDATE = 2;      //  更新模型数据
    const MODEL_BOTH = 3;      //  包含上面两种方式
    const MUST_VALIDATE = 1;      // 必须验证
    const EXISTS_VALIDATE = 0;      // 表单存在字段则验证
    const VALUE_VALIDATE = 2;      // 表单值不为空则验证

    // 最近错误信息
    protected $error = [];
    protected $options = [];
    protected $_validate = [];  // 自动验证定义
    protected $table = '';  // 表名
    protected $_auto = [];  // 自动完成定义
    /**
     * 自动验证数据
     * @param array $data
     */
    public function validate($data=[]) {
        if(!empty($data)){
            if($this->_validate){
                foreach($this->_validate as $key=>$val) {
                    if(empty($val[5]) ) {
                        $val[3]  =  isset($val[3])?$val[3]:self::EXISTS_VALIDATE;
                        $val[4]  =  isset($val[4])?$val[4]:'regex';
                        // 判断验证条件
                        switch($val[3]) {
                            case self::MUST_VALIDATE:   // 必须验证 不管表单是否有设置该字段
                                if(false === $this->_validationField($data,$val))
                                    return false;
                                break;
                            case self::VALUE_VALIDATE:    // 值不为空的时候才验证
                                if('' != trim($data[$val[0]]))
                                    if(false === $this->_validationField($data,$val))
                                        return false;
                                break;
                            default:    // 默认表单存在该字段就验证
                                if(isset($data[$val[0]]))
                                    if(false === $this->_validationField($data,$val))
                                        return false;
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }
    /**
     * 验证表单字段 支持批量验证
     * 如果批量验证返回错误的数组信息
     * @access protected
     * @param array $data 创建数据
     * @param array $val 验证因子
     * @return boolean
     */
    protected function _validationField($data,$val) {
        if( isset($this->error[$val[0]]))
            return false; //当前字段已经有规则验证没有通过
        if(false === $this->_validationFieldItem($data,$val)){
            $this->error = $val[2];
            return false;
        }
        return true;
    }
    /**
     * 根据验证因子验证字段
     * @access protected
     * @param array $data 创建数据
     * @param array $val 验证因子
     * @return boolean
     */
    protected function _validationFieldItem($data,$val) {
        switch(strtolower(trim($val[4]))) {
            case 'function':// 使用函数进行验证
            case 'callback':// 调用方法进行验证
                $args = isset($val[6])?(array)$val[6]:array();
                if(is_string($val[0]) && strpos($val[0], ','))
                    $val[0] = explode(',', $val[0]);
                if(is_array($val[0])){
                    // 支持多个字段验证
                    foreach($val[0] as $field)
                        $_data[$field] = $data[$field];
                    array_unshift($args, $_data);
                }else{
                    array_unshift($args, $data[$val[0]]);
                }
                if('function'==$val[4]) {
                    return call_user_func_array($val[1], $args);
                }else{
                    return call_user_func_array(array(&$this, $val[1]), $args);
                }
            case 'confirm': // 验证两个字段是否相同
                return $data[$val[0]] == $data[$val[1]];
            case 'unique': // 验证某个值是否唯一
                if(is_string($val[0]) && strpos($val[0],','))
                    $val[0]  =  explode(',',$val[0]);
                $map = array();
                if(is_array($val[0])) {
                    // 支持多个字段验证
                    foreach ($val[0] as $field)
                        $map[$field]   =  $data[$field];
                }else{
                    $map[$val[0]] = $data[$val[0]];
                }
                $pk =  $data[0];
                if(!empty($data[$pk]) && is_string($pk)) { // 完善编辑的时候验证唯一
                    $map[$pk] = array('neq',$data[$pk]);
                }
                if(!empty($this->table)){
                    if(DB::count($this->table,$map))   return false;
                }
                return true;
            default:  // 检查附加规则
                return $this->check($data[$val[0]],$val[1],$val[4]);
        }
    }
    /**
     * 验证数据 支持 in between equal length regex expire ip_allow ip_deny
     * @access public
     * @param string $value 验证数据
     * @param mixed $rule 验证表达式
     * @param string $type 验证方式 默认为正则验证
     * @return boolean
     */
    public function check($value,$rule,$type='regex'){
        $type   =   strtolower(trim($type));
        switch($type) {
            case 'in': // 验证是否在某个指定范围之内 逗号分隔字符串或者数组
            case 'notin':
                $range   = is_array($rule)? $rule : explode(',',$rule);
                return $type == 'in' ? in_array($value ,$range) : !in_array($value ,$range);
            case 'between': // 验证是否在某个范围
            case 'notbetween': // 验证是否不在某个范围
                if (is_array($rule)){
                    $min    =    $rule[0];
                    $max    =    $rule[1];
                }else{
                    list($min,$max)   =  explode(',',$rule);
                }
                return $type == 'between' ? $value>=$min && $value<=$max : $value<$min || $value>$max;
            case 'equal': // 验证是否等于某个值
            case 'notequal': // 验证是否等于某个值
                return $type == 'equal' ? $value == $rule : $value != $rule;
            case 'length': // 验证长度
                $length  =  mb_strlen($value,'utf-8'); // 当前数据长度
                if(strpos($rule,',')) { // 长度区间
                    list($min,$max)   =  explode(',',$rule);
                    return $length >= $min && $length <= $max;
                }else{// 指定长度
                    return $length == $rule;
                }
            case 'expire':
                list($start,$end)   =  explode(',',$rule);
                if(!is_numeric($start)) $start   =  strtotime($start);
                if(!is_numeric($end)) $end   =  strtotime($end);
                return TIMESTAMP >= $start && TIMESTAMP <= $end;
            case 'ip_allow': // IP 操作许可验证
                return in_array(getIP(),explode(',',$rule));
            case 'ip_deny': // IP 操作禁止验证
                return !in_array(getIP(),explode(',',$rule));
            case 'regex':
            default:    // 默认使用正则验证 可以使用验证类中定义的验证名称
                // 检查附加规则
                return $this->regex($value,$rule);
        }
    }
    /**
     * 使用正则验证数据
     * @access public
     * @param string $value  要验证的数据
     * @param string $rule 验证规则
     * @return boolean
     */
    public function regex($value,$rule) {
        $validate = array(
            'require'   =>  '/\S+/',
            'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency'  =>  '/^\d+(\.\d+)?$/',
            'number'    =>  '/^\d+$/',
            'zip'       =>  '/^\d{6}$/',
            'integer'   =>  '/^[-\+]?\d+$/',
            'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
            'english'   =>  '/^[A-Za-z]+$/',
        );
        // 检查是否有内置的正则表达式
        if(isset($validate[strtolower($rule)]))
            $rule       =   $validate[strtolower($rule)];
        return preg_match($rule,$value)===1;
    }
    /**
     * 自动表单处理
     * @access public
     * @param array $data 创建数据
     * @param string $type 创建类型
     * @return mixed
     */
    public function autoOperation(&$data,$type=1) {
        $_auto = $this->_auto;
        // 自动填充
        if(isset($_auto)) {
            foreach ($_auto as $auto){
                // 填充因子定义格式
                // array('field','填充内容','填充条件','附加规则',[额外参数])
                if(empty($auto[2])) $auto[2] =  self::MODEL_INSERT; // 默认为新增的时候自动填充
                if( $type == $auto[2] || $auto[2] == self::MODEL_BOTH) {
                    if(empty($auto[3])) $auto[3] =  'string';
                    switch(trim($auto[3])) {
                        case 'function':    //  使用函数进行填充 字段的值作为参数
                        case 'callback': // 使用回调方法
                            $args = isset($auto[4])?(array)$auto[4]:array();
                            if(isset($data[$auto[0]])) {
                                array_unshift($args,$data[$auto[0]]);
                            }
                            if('function'==$auto[3]) {
                                $data[$auto[0]]  = call_user_func_array($auto[1], $args);
                            }else{
                                $data[$auto[0]]  =  call_user_func_array(array(&$this,$auto[1]), $args);
                            }
                            break;
                        case 'field':    // 用其它字段的值进行填充
                            $data[$auto[0]] = $data[$auto[1]];
                            break;
                        case 'ignore': // 为空忽略
                            if($auto[1]===$data[$auto[0]])
                                unset($data[$auto[0]]);
                            break;
                        case 'string':
                        default: // 默认作为字符串填充
                            $data[$auto[0]] = $auto[1];
                    }
                    if(isset($data[$auto[0]]) && false === $data[$auto[0]] )   unset($data[$auto[0]]);
                }
            }
        }
        // 验证完成生成数据对象,去掉MAGIC_QUOTES_GPC产生的
        /*foreach ($data as $key=>$val){
            $data[$key] = MAGIC_QUOTES_GPC && is_string($val) ? stripslashes($val) : $data[$key];
        }*/
        return $data;
    }
    /**
     * 返回模型的错误信息
     * @access public
     * @return string
     */
    public function getError(){
        return $this->error;
    }
}