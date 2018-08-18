<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ImageProcess {
    private $originalImage = null;
    private $originalExt;
    private $originalImagePath;
    private $originalSize    = null;
    private $newImage        = null;
    const VER_CODE_TEXT_LEFT = 0;
    const VER_CODE_TEXT_TOP  = 20;
    const VER_TTF_PATH       = '/resources/fonttype/simhei.ttf';
    public function createFileImage($file) {
        $this->originalSize = getimagesize($file);
        $ext                = $this->originalSize['mime'];
        if (!in_array($ext, ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp'])) {
            return false;
        }
        $this->originalExt       = $ext;
        $this->originalImagePath = $file;
        switch ($ext) {
        case 'image/jpg':
        case 'image/jpeg':
            $this->originalImage = imagecreatefromjpeg($file);
            break;
        case 'image/png':
            $this->originalImage = imagecreatefrompng($file);
            break;
        case 'image/gif':
            $this->originalImage = imagecreatefromgif($file);
            break;
        case 'image/bmp':
            $this->originalImage = imagecreatefrombmp($file);
            break;
        }
        if (!$this->originalImage) {
            return false;
        }
        return true;
    }
    public function createFromString($str, $ext = 'png') {
        $this->originalImage = imagecreatefromstring($str);
        $this->originalExt   = $ext;
    }
    public function condense($path, $ext = null, $rate = 0.5) {
        if ($this->originalImage == null) {
            return false;
        }
        $outPutWidth  = $this->originalSize[0] * $rate;
        $outPutHeight = $this->originalSize[1] * $rate;
        $outPutImage  = imagecreatetruecolor($outPutWidth, $outPutHeight);
        $copyRes      = imagecopyresized($outPutImage, $this->originalImage, 0, 0, 0, 0, $outPutWidth, $outPutHeight, $this->originalSize[0], $this->originalSize[1]);
        if ($copyRes) {
            if (empty($ext)) {
                $tmp = explode('.', $this->originalImagePath);
                $ext = $tmp[count($tmp) - 1];
            }
            $this->outPutImage($outPutImage, $path . '.' . $ext, $ext);
        }
        imagedestroy($outPutImage);
        return $copyRes;
    }
    public function outPutImage(&$image, $file, $ext) {
        switch ($ext) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($image, $file);
            break;
        case 'png':
            imagepng($image, $file);
            break;
        case 'gif':
            imagegif($image, $file);
            break;
        case 'bmp':
            imagebmp($image, $file);
            break;
        }
    }
    public function destroy() {
        if ($this->originalImage) {
            imagedestroy($this->originalImage);
        }

        $this->originalImage = null;
        $this->originalSize  = null;
    }
    public function createVerificationCode($length = 4, $width = 200, $height = 50, $paddingLeftAndRight = 0, $paddingTopAndBotton = 0) {
        $randArr             = $this->randString($length);
        $randLength          = count($randArr);
        $this->originalImage = imagecreatetruecolor($width, $height);
        $white               = imagecolorallocate($this->originalImage, 255, 255, 255);
        imagefilledrectangle($this->originalImage, 0, 0, $width, $height, $white);
        $lineQuantity = rand(5, 15);
        for ($i = 0; $i < $lineQuantity; $i++) {
            $lineColor = imagecolorallocate($this->originalImage, rand(0, 240), rand(0, 240), rand(0, 240));
            imageline($this->originalImage, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
        }
        $strWidth  = ($width - ($paddingLeftAndRight * 2)) / $randLength;
        $strHeight = $height - ($paddingTopAndBotton * 2);
        $step      = 0;
        $ret       = '';
        foreach ($randArr as $str) {
            $left = $paddingLeftAndRight + ($strWidth * $step);
            $this->addStringToImage($this->originalImage, $str, $left, $paddingTopAndBotton, $strWidth, $strHeight);
            $step++;
            $ret .= $str;
        }
        return $ret;
    }
    public function showCreateImage($ext = 'png') {
        switch ($ext) {
        case 'jpg':
        case 'jpeg':
            header('Content-type:image/jpeg');
            imagejpeg($this->originalImage);
            break;
        case 'png':
            header('Content-type:image/png');
            imagepng($this->originalImage);
            break;
        case 'gif':
            header('Content-type:image/gif');
            imagegif($this->originalImage);
            break;
        case 'bmp':
            header('Content-type:image/bmp');
            imagebmp($this->originalImage);
            break;
        }
    }
    private function addStringToImage(&$img, &$str, $left, $top, $cellWidth, $cellHeight) {
        $strColor = imagecolorallocate($img, rand(0, 240), rand(0, 240), rand(0, 240));
        $rat      = rand(0, 30);
        if (rand(0, 1)) {
            $rat = -1 * $rat;
        }
        imagettftext($img, rand(15, 30), $rat, SELF::VER_CODE_TEXT_LEFT + $left, SELF::VER_CODE_TEXT_TOP + $top, $strColor, INDEXPATH . SELF::VER_TTF_PATH, $str);
    }
    private function randString($length) {
        $str     = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $strLast = strlen($str) - 1;
        $ret     = [];
        for ($i = 0; $i < $length; $i++) {
            $ret[] = substr($str, rand(0, $strLast), 1);
        }
        return $ret;
    }
}