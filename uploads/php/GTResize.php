<?php
class GTResize
{
    const QUALITY = 85;
    private $filedir = ''; //文件路径
    private $srcFile;
    private $toFile;
    private $im;
    private $waterfile = './watermark.png';
    private $waterWidth = 300;
    private $waterHeight = 300;
    private $waterstats = true;
    private $waterPosition = 'br';
    private $allowsize = array('250-250','150-150','170-70','200-200','80-80','90-90','35-35','160-150','170-150','500-0','400-0','100-100','0-0');
    public function __construct($srcFile,$toFile, $waterfile=''){
        if(!file_exists($srcFile)){
            die('图片路径错误');
        }
        $this->srcFile = $srcFile;
        $this->toFile = $toFile;
        $this->waterfile = $waterfile ? $waterfile : $this->waterfile;
    }
    /**
     * 设置加水印条件
     */
    public function setWaterSize($minWidth,$minHeight){
        $this->waterWidth = $minWidth;
        $this->waterHeight = $minHeight;
    }
    /**
     * 设置水印位置
     */
    public function setWaterPosition($pos){
        $this->waterPosition = $pos;
    }
    private function _extIm(){
        $this->im = false;
        $data = getimagesize($this->srcFile);
        switch ($data[2]) {
            /*
            case 1: // gif
                if (!function_exists("imagecreatefromgif")) {
                    echo "您的GD2库不能使用GIF格式的图片,请使用JPEG或PNG格式！ ";
                    exit();
                }
                $this->im = imagecreatefromgif($this->srcFile);
                break;
            */
            case 2: // jpg
                if (!function_exists("imagecreatefromjpeg")) {
                    echo "您的GD2库不能使用JPEG格式的图片,请使用其他格式的图片！ ";
                    exit();
                }
                $this->im = imagecreatefromjpeg($this->srcFile);
                break;
            case 3: // png
                $this->im = imagecreatefrompng($this->srcFile);
                break;
        }  
    }
    /**
     * 获取目标路径
     * @param $type resizeNoFill cutAndResize reSizeAndFill
     */
    public function getToFile($type = 'resizeNoFill',$ftoW,$ftoH){
        /*
        if(!in_array($ftoW.'-'.$ftoH,$this->allowsize)){
            file_put_contents($this->filedir.'/not_allow_size.txt',$ftoW.'-'.$ftoH." not allowed.\n",FILE_APPEND);            
        }*/
        if(file_exists($this->toFile)){
            return $this->toFile;
        }
        if(!file_exists($this->srcFile)){
            return false;
        }
        $this->_extIm();
        if(strpos($this->srcFile,'nowater/') !== false){
            $this->waterstats = false;
        }
        $ftoW or $ftoW = ImageSX($this->im);
        $ftoH or $ftoH = ImageSY($this->im);
        //创建目标目录
        $filedir = dirname($this->toFile);
        if(!file_exists($filedir)){
            mkdir($filedir,0777,true);
        }
        //直接复制
        if($this->im === false){
            copy($this->srcFile,$this->toFile);
        }else{
            //开始执行压缩
            $this->$type($ftoW,$ftoH);
        }
        //如果没有生成目标文件
        if(!file_exists($this->toFile)){
            return false;
        }
        return $this->toFile;
    }
    private function imToImage($ni,$w,$h){
        if($this->waterstats && $w >= $this->waterWidth && $h >= $this->waterHeight){
            $ni = $this->water_image($ni);
        }
        if (function_exists('imagejpeg'))
            imagejpeg($ni, $this->toFile,self::QUALITY);
        else
            imagepng($ni, $this->toFile,self::QUALITY);
        imagedestroy($ni);
        imagedestroy($this->im);
    }
    /**
     * 生成缩略图,生成按指定高宽等比压缩的缩略图，超出部分不留空白
     */
    public function resizeNoFill($ftoW, $ftoH){
        $srcW = ImageSX($this->im);
        $srcH = ImageSY($this->im);
        ////////////////  等比设置 /////////////////////////////////
        if (($ftoW && $srcW > $ftoW) || ($ftoH && $srcH > $ftoH)) {
            $RESIZEWIDTH = $RESIZEHEIGHT = false;
            if ($ftoW && $srcW > $ftoW) {
                $widthratio = $ftoW / $srcW;
                $RESIZEWIDTH = true;
            }
            if ($ftoH && $srcH > $ftoH) {
                $heightratio = $ftoH / $srcH;
                $RESIZEHEIGHT = true;
            }
            if ($RESIZEWIDTH && $RESIZEHEIGHT) {
                if ($widthratio < $heightratio) {
                    $ratio = $widthratio;
                } else {
                    $ratio = $heightratio;
                }
            } elseif ($RESIZEWIDTH) {
                $ratio = $widthratio;
            } elseif ($RESIZEHEIGHT) {
                $ratio = $heightratio;
            }
            $ftoW = $srcW * $ratio;
            $ftoH = $srcH * $ratio;
        }
        if($srcW <= $ftoW){
            $ftoW = $srcW;
            $ftoH = $srcH;
        }
        ////////////////  等比设置 End /////////////////////////////////
        //$ftoW=185 ; //round($srcW/3);
        //$ftoH=120 ; //round($srcH/3);
        if (function_exists("imagecreatetruecolor")) {
            $ni = imagecreatetruecolor($ftoW, $ftoH);
            if ($ni){
                ImageCopyResampled($ni, $this->im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
            }
            else {
                $ni = ImageCreate($ftoW, $ftoH);
                imagecopyresized($ni, $this->im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
            }
            
        } else {
            $ni = ImageCreate($ftoW, $ftoH);
            imagecopyresized($ni, $this->im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
        }
        $this->imToImage($ni,$ftoW,$ftoH);
    }
    // 剪裁并压缩图片
    public function cutAndResize($ftoW, $ftoH){
        $srcW = ImageSX($this->im);
        $srcH = ImageSY($this->im);
    
        $src_x = 0;
        $src_y = 0;
        $src_w = $srcW;
        $src_h = $srcH;
        // 宽高比，判断是裁掉下面的还是右边的
        if ($ftoW / $ftoH <= $srcW / $srcH) // 现有的图片宽了，需要裁掉两边
            {
            $src_w = $srcH * $ftoW / $ftoH;
            $src_x = ($srcW - $src_w) / 2;
        } else // 现有的图片窄了，需要裁掉一点头尾
        {
            $src_h = $srcW * $ftoH / $ftoW;
            $src_y = ($srcH - $src_h) / 2;
        }
        if (function_exists("imagecreatetruecolor")) {
            $ni = imagecreatetruecolor($ftoW, $ftoH);
            if ($ni)
                ImageCopyResampled($ni, $this->im, 0, 0, $src_x, $src_y, $ftoW, $ftoH, $src_w, $src_h);
            else {
                $ni = ImageCreate($ftoW, $ftoH);
                imagecopyresized($ni, $this->im, 0, 0, $src_x, $src_y, $ftoW, $ftoH, $src_w, $src_h);
            }
        } else {
            $ni = ImageCreate($ftoW, $ftoH);
            imagecopyresized($ni, $this->im, 0, 0, $src_x, $src_y, $ftoW, $ftoH, $src_w, $src_h);
        }
        $this->imToImage($ni,$ftoW,$ftoH);
    }
    /**
     * 生成缩略图，生成按指定高宽等比压缩的缩略图，如果有空白，则以底色填充，同时将图片生成在画布中间位置
     */
    public function resizeAndFill($ftoW, $ftoH, $r = 255, $g = 255, $b =
    255){
        $srcW = ImageSX($this->im);
        $srcH = ImageSY($this->im);
        ////////////////  寻找起始点 /////////////////////////////////////
        $rtow = $srcW;
        $rtoh = $srcH;
        if (($srcW > $ftoW) || ($srcH > $ftoH)) {
            if ($srcW / $srcH > $ftoW / $ftoH) //超宽
                {
                $rtow = $ftoW;
                $rtoh = floor($srcH * $rtow / $srcW);
            } else // 超高
            {
                $rtoh = $ftoH;
                $rtow = floor($srcW * $rtoh / $srcH);
            }
        }
        $startx = floor(($ftoW - $rtow) / 2);
        $starty = floor(($ftoH - $rtoh) / 2);
        ////////////////  寻找起始点 End /////////////////////////////////
    
        if (function_exists("imagecreatetruecolor")) {
            $ni = imagecreatetruecolor($ftoW, $ftoH);
            if ($ni) {
                // 填充底色
                $bg = imagecolorallocate($ni, $r, $g, $b);
                imagefill($ni, 0, 0, $bg);
                ImageCopyResampled($ni, $this->im, $startx, $starty, 0, 0, $rtow, $rtoh, $srcW, $srcH);
            } else {
                $ni = ImageCreate($ftoW, $ftoH);
                // 填充底色
                $bg = imagecolorallocate($ni, $r, $g, $b);
                imagefill($ni, 0, 0, $bg);
                imagecopyresized($ni, $this->im, $startx, $starty, 0, 0, $rtow, $rtoh, $srcW, $srcH);
            }
        } else {
            $ni = ImageCreate($ftoW, $ftoH);
            // 填充底色
            $bg = imagecolorallocate($ni, $r, $g, $b);
            imagefill($ni, 0, 0, $bg);
            imagecopyresized($ni, $this->im, $startx, $starty, 0, 0, $rtow, $rtoh, $srcW, $srcH);
        }
        $this->imToImage($ni,$ftoW,$ftoH);
    }
    /**
     * 图片加水印
     */
    public function water_image($newim){
        if (file_exists($this->waterfile)) {
            $water = imagecreatefrompng($this->waterfile);
            $ww = imagesx($water);
            $wh = imagesy($water);
            $newwidth = imagesx($newim);
            $newheight = imagesy($newim);
            $sl = false;
            if ($ww > ($newwidth / 1.5)) {
                $wwj = round($newwidth / 1.5);
                $whj = round($wh * ($wwj / $ww));
                $sl = true;
            } elseif ($wh > ($newheight / 1.5)) {
                $whj = round($newheight / 1.5);
                $wwj = round($ww * ($whj / $wh));
                $sl = true;
            }
            if ($sl) {
                if (function_exists("imagecopyresampled")) {
                    $swater = imagecreatetruecolor($wwj, $whj);
                    imagesavealpha($swater, true);
                    $traswater = imagecolorallocatealpha($swater, 0, 0, 0, 127);
                    imagefill($swater, 0, 0, $traswater);
                    imagecopyresampled($swater, $water, 0, 0, 0, 0, $wwj, $whj, $ww, $wh);
                } else {
                    $swater = imagecreate($wwj, $whj);
                    imagecopyresized($swater, $water, 0, 0, 0, 0, $wwj, $whj, $ww, $wh);
                }
                $water = $swater;
                $ww = $wwj;
                $wh = $whj;
            }
            //水印位置
            switch($this->waterPosition){
                case 'br':  //右下
                    $nw = $newwidth - $ww - 10;
                    $nh = $newheight - $wh - 10;
                    break;
                case 'bl':  //左下
                    $nw = 20;
                    $nh = $newheight - $wh - 10;
                    break;
                case 'tr':  //右上
                    $nw = $newwidth - $ww - 10;
                    $nh = 20;
                    break;
                case 'tl':  //左上
                    $nw = 20;
                    $nh = 20;
                    break;
                default:  //中央
                    $nw = ($newwidth - $ww)/2;
                    $nh = ($newheight - $wh)/2;
            }
            imagecopy($newim, $water, $nw, $nh, 0, 0, $ww, $wh);
        }
        return $newim;
    }
}