<?php declare(strict_types=1);

namespace site\handler\api\captcha;

use Imagick;
use ImagickDraw;
use ImagickPixel;
use lzx\core\Response;
use lzx\exception\Forbidden;
use site\Config;
use site\Service;

class Handler extends Service
{
    public function get(): void
    {
        if (!($this->request->referer && $this->args)) {
            throw new Forbidden();
        }

        $code = substr(str_shuffle('aABCdEeFfGHKLMmNPRSTWXY23456789'), -5);
        $this->session->set('captcha', $code);

        $this->response->type = Response::JPEG;
        $this->response->setContent(self::generateImage(str_split($code), 'jpeg'));
    }

    private static function generateImage(array $code, string $format): Imagick
    {
        $config = Config::getInstance();
        $font = $config->path['file'] . '/fonts/Tuffy.ttf';

        $font_size = 36;
        $box_width = $font_size;
        $box_height = (int) ($font_size * 1.2);

        $text = new ImagickDraw();
        $text->setFont($font);
        $text->setFontSize($font_size);
        $text->setGravity(Imagick::GRAVITY_CENTER);

        $boxes = new Imagick();
        foreach ($code as $c) {
            $boxes->newimage($box_width, $box_height, '#FFFFFF', $format);
            $text->setFillColor(self::getRandomColor());
            $x = rand(-3, 3);
            $y = rand(-8, 8);
            $a = rand(-20, 20);
            $boxes->annotateimage($text, $x, $y, $a, $c);
        }
        $boxes->rewind();
        $image = $boxes->appendimages(false);
        $boxes->destroy();

        self::addNoise($image);
        return $image;
    }

    private static function addNoise(Imagick $image): void
    {
        $w = $image->getimagewidth();
        $h = $image->getimageheight();
        $noise = new ImagickDraw();
        $noise->setstrokewidth(1);
        $noiseLevel = 6;
        for ($i = 0; $i < $noiseLevel; $i++) {
            $noise->setstrokecolor(self::getRandomColor());
            $noise->line(rand(0, $w), rand(0, $h), rand(0, $w), rand(0, $h));
        }
        $image->drawImage($noise);

        $image->waveImage(3, rand(60, 100));
        $image->addnoiseimage(Imagick::NOISE_IMPULSE);
    }

    private static function getRandomColor(): ImagickPixel
    {
        $hex_dark = '#' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        return new ImagickPixel($hex_dark);
    }
}
