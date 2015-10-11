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
}
