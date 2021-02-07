<?php
namespace App\Controller;
use WyPhp\DB;
class finance extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            $limit = G('limit','int',20);
            $where = [];
            $field = G('field_key','int','');
            $sort = G('sort');
            $order = $field ===0 ? (' order_id '.$sort) : ' addtime desc';

            if($field){
                if($field == 1){
                    $order = ' total '.$sort;
                }
                if($field == 2){
                    $order = ' checkout_price '.$sort;
                }
                if($field == 4){
                    $order = ' loss_fee '.$sort;
                }
                if($field == 5){
                    $order = ' addtime '.$sort;
                }
                if($field == 3){
                    $order = ' shipping_fee '.$sort;
                }
            }

            $list = DB::fetch_all('payments','*',$where, $order,$limit,$this->page,'','',['prefix'=>'fi_']);
            $total = 0;
            if ($list) {
                foreach ($list as $key => $value) {

                    $list[$key]['addtime'] = date('Y-m-d H:i',$value['addtime']);
                    $list[$key]['amount'] = '￥'.$value['amount'];

                }
                $total = DB::count('payments', $where,['prefix'=>'fi_']);
            }
            $response = [
                'data' =>$list,
                'limit' =>$limit,
                'page' =>$this->page,
                'total' =>$total
            ];
            $this->printJson($response);
        }

        $this->render();
    }
}