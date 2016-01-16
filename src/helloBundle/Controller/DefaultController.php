<?php

namespace helloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('helloBundle:Default:index.html.twig');
    }
     public function introAction()
    {
        return $this->render('helloBundle:Default:intro.html.twig');
    }
}

