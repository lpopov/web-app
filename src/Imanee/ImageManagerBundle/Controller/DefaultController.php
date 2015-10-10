<?php

namespace Imanee\ImageManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ImaneeImageManagerBundle:Default:index.html.twig');
    }

    public function handleUploadAction()
    {

    }
}
