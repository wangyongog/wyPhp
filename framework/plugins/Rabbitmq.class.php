<?php
namespace WyPhp;
require_once FWPATH . '/plugins/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class Rabbitmq {
    protected $connection = null;
    protected $channel = null;
    //交换机类型:直连交换机（direct）, 主题交换机（topic）, （头交换机）headers和 扇型交换机（fanout）
    public $exchangeType = AMQPExchangeType::DIRECT;
    //交换机名
    public $exchange = 'wy_exchange';
    public function __construct(){
        try{
            $config = CF('rabbitmq');
            if(empty($config)){
                throw new \Exception('缺少参数');
            }
            $this->connection = new AMQPStreamConnection($config['host'],$config['port'],$config['username'],$config['password'], $config['vhost']);
            $this->channel = $this->connection->channel();
        }catch(AMQPRuntimeException $e) {
            Error::error($e->getMessage());
        } catch(\RuntimeException $e) {
            Error::error($e->getMessage());
        } catch(\ErrorException $e) {
            Error::error($e->getMessage());
        }catch (\Exception $e){
            Error::error($e->getMessage());
        }
    }

    /**
     * 发送队列消息
     * @param $queue
     * @param $msg
     */
    public function sendMessage($queue, $msg){
        //定义持久化队列
        $this->channel->queue_declare($queue, false, true, false, false);
        //创建一个exchangeType类型的交换机
        $this->channel->exchange_declare($this->exchange, $this->exchangeType, false, true, false);
        //绑定交换机和队列
        $this->channel->queue_bind($queue, $this->exchange);

        //$msg = implode(' ', array_slice($argv, 1));
        //发送消息
        $message = new AMQPMessage($msg, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $this->channel->basic_publish($message, $this->exchange);
        $this->close();
    }

    /**
     * 获取队列消息
     * @param $queue
     * @return mixed
     */
    public function getMessage($queue){
        try{
            $message = $this->channel->basic_get($queue);
            if(!$message){
                $this->close();
                return '';
            }
            $this->channel->basic_ack($message->delivery_info['delivery_tag']);
            $this->close();
            return $message->body;
        }catch (AMQPProtocolChannelException $e){
            Error::error($e->getMessage());
        }
    }
    public function close(){
        $this->channel and $this->channel->close();
        $this->connection and $this->connection->close();
    }

}