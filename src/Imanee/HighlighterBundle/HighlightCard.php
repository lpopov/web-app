<?php
/**
 * Class representing a "card" with a user highlight
 */

namespace Imanee\HighlighterBundle;

use Imanee\Drawer;
use Imanee\Imanee;

class HighlightCard
{
    /** @var  string */
    protected $quoteAuthor;

    /** @var  string */
    protected $quoteAvatar;

    /** @var  string */
    protected $sourceLogo;

    /** @var  array */
    protected $defaults;

    public function __construct(array $settings = [])
    {
        $this->setQuoteAvatar(__DIR__ . '/Resources/img/avatar.png');
        $this->setSourceLogo(__DIR__ . '/Resources/img/imanee-icon.png');
        $this->setQuoteAuthor('Anonymous');

        $this->setDefaults(array_merge([
            'font_file'    => __DIR__ . '/Resources/fonts/quote_default.otf',
            'font_size'    => 30,
            'line_spacing' => 5,
            'padding'      => 10,
            'color'        => '#333333',
            'background'   => '#F5F5F5'
        ], $settings));
    }

    /**
     * @return string
     */
    public function getQuoteAuthor()
    {
        return $this->quoteAuthor;
    }

    /**
     * @param string $quoteAuthor
     */
    public function setQuoteAuthor($quoteAuthor)
    {
        $this->quoteAuthor = $quoteAuthor;
    }

    /**
     * @return string
     */
    public function getQuoteAvatar()
    {
        return $this->quoteAvatar;
    }

    /**
     * @param string $quoteAvatar
     */
    public function setQuoteAvatar($quoteAvatar)
    {
        $this->quoteAvatar = $quoteAvatar;
    }


    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @param array $defaults
     */
    public function setDefaults($defaults)
    {
        $this->defaults = $defaults;
    }

    /**
     * @return string
     */
    public function getSourceLogo()
    {
        return $this->sourceLogo;
    }

    /**
     * @param string $sourceLogo
     */
    public function setSourceLogo($sourceLogo)
    {
        $this->sourceLogo = $sourceLogo;
    }

    /**
     * @param $setting
     * @return null
     */
    public function get($setting)
    {
        return isset($this->defaults[$setting]) ? $this->defaults[$setting] : null;
    }

    public function generateQuoteCard($text, $width = 500)
    {
        $font = $this->get('font_file');
        $fontSize = $this->get('font_size');
        $lineSpacing = $this->get('line_spacing');
        $padding = $this->get('padding');
        $background = $this->get('background');
        $color = $this->get('color');

        $wrap = wordwrap($text, 30, '------');
        $lines = explode('------', $wrap);

        $drawer = new Drawer();
        $drawer
            ->setFont($font)
            ->setFontColor($color)
            ->setFontSize($fontSize);

        $header = $this->getImageHeader($width, 60);

        // calculates image size
        $height = (($fontSize + $padding) * count($lines)) + $header->getHeight();
        $width = ($fontSize / 2) * 30 ;

        $imanee = new Imanee();
        $imanee->newImage($width, $height, $background);
        $imanee->placeImage($header, Imanee::IM_POS_TOP_LEFT);
        $imanee->setDrawer($drawer);

        $cx = $padding;
        $cy = $header->getHeight() + $padding + $fontSize;
        $iter = 0;

        foreach ($lines as $line) {
            if (!$iter) {
                $line = '"' . $line;
            }

            $iter++;

            if ($iter >= count($lines)) {
                $line = $line . '"';
            }

            $imanee->annotate($line, $cx, $cy);
            $cy += $fontSize + $lineSpacing;
        }

        return $imanee;
    }

    public function getImageHeader($width, $height)
    {
        $fontsize = 16;
        $imageSize = 60;
        $padding = $this->get('padding');

        $header = new Imanee();
        $header->newImage($width, $height + (2*$padding), '#E5E5E5');

        $drawer = new Drawer();
        $drawer
            ->setFont($this->get('font_file'))
            ->setFontColor($this->get('color'))
            ->setFontSize($fontsize);

        $header->setDrawer($drawer);

        $header
            ->compositeImage($this->getQuoteAvatar(), $padding, $padding, $imageSize, $imageSize)
            ->compositeImage(
                $this->getSourceLogo(),
                $header->getWidth() - $padding - ($imageSize*2),
                $padding,
                $imageSize,
                $imageSize
            )
            ->annotate($this->getQuoteAuthor(), $imageSize + (2*$padding), $padding + ($imageSize/3) + $fontsize);

        //$header->placeText($this->getQuoteAuthor(), Imanee::IM_POS_TOP_CENTER);
        //$header->placeImage($this->getQuoteAvatar(), Imanee::IM_POS_TOP_LEFT, 60, 60);
        //$header->placeImage($this->getSourceLogo(), Imanee::IM_POS_TOP_RIGHT, 60, 60);

        return $header;
    }
}
