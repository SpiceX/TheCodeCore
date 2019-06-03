<?php
declare(strict_types=1);

namespace EversoftTeam\Utils;

use EversoftTeam\Main;

class PlayerFaceAPI
{
    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }


    public static function action($data, $height = 64, $width = 64)
    {
        $pixelarray = str_split(bin2hex($data), 8);
        $image = imagecreatetruecolor($width, $height);
        imagealphablending($image, false);//do not touch
        imagesavealpha($image, true);
        $position = count($pixelarray) - 1;
        while (!empty($pixelarray)) {
            $x = $position % $width;
            $y = ($position - $x) / $height;
            $walkable = str_split(array_pop($pixelarray), 2);
            $color = array_map(function ($val) {
                return hexdec($val);
            }, $walkable);
            $alpha = array_pop($color);
            $alpha = ((~((int)$alpha)) & 0xff) >> 1;
            array_push($color, $alpha);
            imagesetpixel($image, $x, $y, imagecolorallocatealpha($image, ...$color));
            $position--;
        }
        return $image;
    }

    public function crearImagen($ancho, $alto)
    {
        $image = imagecreatetruecolor($ancho, $alto);
        imagesavealpha($image, true);
        imagealphablending($image, false);
        $fill = imagecolorallocatealpha($image, 255, 255, 255, 127);
        imagefill($image, 0, 0, $fill);
        return $image;
    }

    public function extraerHead($name, $fileA, $extension = ".png")
    {
        $png = $name . $extension;
        $image = imagecreatefrompng($fileA . $png);
        unlink($fileA . $png);
        $target_one = $this->crearImagen(8, 8);
        for ($y = 8; $y < 16; ++$y) {
            for ($x = 8; $x < 16; ++$x) {
                imagesetpixel($target_one, $x - 8, $y - 8, imagecolorat($image, $x, $y));
            }
        }

        for ($y = 7; $y < 15; ++$y) {
            for ($x = 40; $x < 48; ++$x) {
                $color = imagecolorat($image, $x, $y);
                $index = imagecolorsforindex($image, $color);
                if ($index["alpha"] === 127) {
                    continue;
                }
                imagesetpixel($target_one, $x - 40, $y - 8, $color);
            }
        }
        imagedestroy($image);
        $final = $this->crearImagen(1080, 1080);
        imagecopyresized($final, $target_one, 0, 0, 0, 0, imagesx($final), imagesy($final), imagesx($target_one), imagesy($target_one));
        imagedestroy($target_one);
        imagepng($final, $fileA . $png);
        imagedestroy($final);
    }

    public function sendHead($name, $data, $extension = ".png")
    {
        $img = self::action($data);
        imagepng($img, $this->main->getServer()->getDataPath() . "playerheads/" . $name . $extension);
        $this->extraerHead($name, $this->main->getServer()->getDataPath() . "playerheads/");
    }

    public function delete($name)
    {
        unlink($this->main->getServer()->getDataPath() . "playerheads/" . $name . ".png");

    }
}