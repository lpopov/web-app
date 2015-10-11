<?php

namespace Imanee\HighlighterBundle\Controller;

use Imanee\Drawer;
use Imanee\HighlighterBundle\HighlightCard;
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

        $card = new HighlightCard();
        $quote = $card->generateQuoteCard($text);
        return new Response($quote->output(), 200, [
           'Content-type' => 'image/jpg'
        ]);
    }
}
