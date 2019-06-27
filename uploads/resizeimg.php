<?php
class CutImg{
    protected $width;
    protected $height;
    protected $srcfile;//来源图片地址 D:\WWW\wyPhp\attaches/uploads/1704893933937459903.jpg
    public $tofile; //保存地址 D:\WWW\wyPhp\attaches/uploads/1704893933937459903_200x200_1_1.jpg
    /**
     * 截取类型
     * 1=>固定比例裁剪，不足空白补齐
     * 2=>固定比例裁剪
     * 3=>等比例裁剪
     */
    protected $cutType = [
        1=>'resizeAndFill',
        2=>'cutAndResize',
        3=>'resizeNoFill'
    ];
    /**
     * 水印位置
     * 1=>右下
     * 2=>左下
     * 3=>右上
     * 4=>左上
     * 5=>中间
     */
    protected $water_pos = [
        1=>'br',
        2=>'bl',
        3=>'tr',
        4=>'tl',
        5=>'mi',
    ];
    protected $imgUrl = '';
    protected $root ;
    protected $cut;
    protected $pos;
    protected $alowType = 'gif|jpg|jpeg|png|bmp';
    public $ext;

    public function __construct($url){
        $this->root = __DIR__;
        $this->imgUrl = htmlspecialchars(strip_tags($url));
        $this->init($this->imgUrl);
    }

    /**
     * @param $url
     */
    protected function init($url=''){
        if(!$url){
            die('404 not found 01');
        }
        preg_match("/(.*?)\_(\w+)\.(".$this->alowType.")$/i", $url,$match);

        $cut_num = count($match);
        if($cut_num<0){
            die('404 not found 02');
        }
        $this->ext = end($match);
        if(!in_array(strtolower($this->ext) , explode('|', $this->alowType))){
            die('not alow img');
        }

        $this->srcfile = empty($match[1]) ? '' : $this->root.$match[1].'.'.$this->ext;
        $this->tofile = empty($match[0]) ? '' : $this->root.$match[0];

        $imgPar = explode('_', $match[2]);
        list($width, $height) = explode('x' ,$imgPar[0]);
        $this->width = intval($width);
        $this->height = intval($height);
        $this->height >= 1000 and $this->height = 0;
        if(!$this->width || !$this->height){
            die('width or height not');
        }

        !empty($imgPar[1]) or $imgPar[1] = 1;
        !empty($imgPar[2]) or $imgPar[2] = 1;
        $this->cut = $this->GetCutType($imgPar[1]);
        $this->pos = $this->GetWaterPos($imgPar[2]);

    }

    /**
     * 生成缩略图
     * @return bool
     */
    public function creatImg(){
        include('./php/GTResize.php');
        $res = new GTResize($this->srcfile, $this->tofile, $this->root.'/php/watermark.png');
        $res->setWaterPosition($this->pos);
        $outfile = $res->getToFile($this->cut ,$this->width,$this->height);
        if($outfile === false){
            die('404 not found 01');
        }
        return $outfile;
    }

    /**
     * 获取水印位置
     * @param $pos
     * @return mixed
     */
    protected function GetWaterPos($pos){
        return isset($this->water_pos[$pos]) ? $this->water_pos[$pos] : $this->water_pos[1];
    }

    /**
     * 获取裁剪类型
     * @param $cutType
     * @return mixed
     */
    protected function GetCutType($cutType){
        return isset($this->cutType[$cutType]) ? $this->cutType[$cutType] : $this->cutType[1];
    }
}
//file_put_contents("D:/WWW/wyPhp/test.txt",json_encode($_GET));
$cutimg = new CutImg($_GET['url']);
$cutimg->creatImg();
if(is_file($cutimg->tofile)){
    header('Content-type: image/'.$cutimg->ext);
    header('Content-Length:'.filesize($cutimg->tofile));
    header("Accept-Ranges: bytes");
    readfile($cutimg->tofile);
}
//header("location:".$_GET['url']);
