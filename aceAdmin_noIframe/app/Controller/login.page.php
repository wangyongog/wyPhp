<?php
namespace App\Controller;
//use Admin\Model\LoginModel;
use Zxing\QrReader;
use WyPhp\Trace;

class login extends baseController {
    public function actionIndex(){
        //$this->caching = false;
        //$this->assign('sss', '11111111');
        //$_SESSION['var2'] = "111";
        //$_SESSION['var3'] = "顶顶顶顶";
        $this->render();
    }
    public function actionHashids(){
        //Hashids是一个小型PHP库，可以从数字中生成类似YouTube的ID。当您不希望向用户公开数据库数字ID时使用它
        require FWPATH . "/plugins/Vendor/autoload.php";
        $hashids = NEW \Hashids\Hashids();
        //$s = $hashids->encode('123a');
        $id = $hashids->encodeHex('123a'); // y42LW46J9luq3Xq9XMly
        $hex = $hashids->decodeHex($id); // 507f1f77bcf86cd799439011
        echo $id.'<br>';
        $numbers = $hashids->decodeHex($id);
        print_r($numbers) ;
        exit;
    }
    public function actionQrReader(){
        //解析二维码图片信息
        require FWPATH . "/plugins/Vendor/autoload.php";
        $qrcode = new QrReader(ROOT.'/assets/www/images/QR.png');
        $url = $qrcode->text(); //return decoded text from QR Code
        echo $url;
    }
    public function actionLogin(){
        $username = G('username');
        $password = G('password');
        $code = G('code');
        if(check_formhash() === false){
            $this->error('无效操作！');
        }
        $login = D('aceAdmin/Manager');
        $uid = $login->login($username, $password);
        if($uid>0){
            $this->success('登录成功','/main');
        }
        switch ($uid) {
            case - 1 :
                $error = '用户不存在或被禁用！';
                break; // 系统级别禁用
            case - 2 :
                $error = '密码错误！';
                break;
            default :
                $error = '未知错误！';
                break;
        }
        $this->error($error);
    }
    public function actionVerify(){
        $config = array(
            'imageW'    =>    160,
            'imageH'    =>    40,
            'fontSize'    =>    22,    // 验证码字体大小
            'length'    =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            'useCurve' =>false
        );
        $verify = new \WyPhp\Verify($config);
        $verify->entry('loginmy');
    }
}