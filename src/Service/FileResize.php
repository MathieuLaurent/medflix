<?php 
namespace App;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class FileResize
{
    private const MAX_WIDTH = 150;
    private const MAX_HEIGHT = 50;

    private const MAX_WIDTH_INTER = 300;
    private const MAX_HEIGHT_INTER = 100;

    private $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resize(string $filename): void
    {
        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }
        $photo = $this->imagine->open($filename);

        $filename = str_replace('img', 'imgMiniature', $filename);

        $photo->resize(new Box($width, $height))->save($filename);
        
    
    }

    public function resizeInter(string $filename): void
    {
        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH_INTER;
        $height = self::MAX_HEIGHT_INTER;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }
        $photo = $this->imagine->open($filename);

        $filename = str_replace('img', 'imgInter', $filename);

        $photo->resize(new Box($width, $height))->save($filename);
        
    
    }
}