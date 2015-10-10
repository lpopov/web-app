<?php

namespace Imanee\ImageManagerBundle\Controller;

use Imanee\Drawer;
use Imanee\Imanee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ImaneeImageManagerBundle:Default:index.html.twig');
    }

    /**
     * Handles image upload
     */
    public function handleUploadAction()
    {

    }

    /**
     * Generates an image from a text quote, optimized for Twitter
     */
    public function generateTweetableAction(Request $request)
    {
        $text = $request->query->get('text');

        if (!$text) {
            throw new \HttpInvalidParamException("You need to provide a text.");
        }

        $wrap = wordwrap($text, 30, '------');
        $lines = explode('------', $wrap);

        $fontSize = 30;
        $lineSpacing = 5;
        $padding = 10;

        $drawer = new Drawer();
        $drawer
            ->setFont(__DIR__ . '/../Resources/fonts/quote_default.otf')
            ->setFontColor('#333333')
            ->setFontSize($fontSize);

        // calculates image size
        $height = ($fontSize + $padding) * count($lines);
        $width = ($fontSize / 2) * 30 ;

        $imanee = new Imanee();
        $imanee->newImage($width, $height);
        $imanee->setDrawer($drawer);

        $cx = $padding;
        $cy = $fontSize + $padding;
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

        return new Response($imanee->output(), 200, [
           'Content-type' => 'image/jpg'
        ]);
    }
}
