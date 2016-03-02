<?php

namespace Neox\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NeoxUserBundle:Default:index.html.twig');
    }
}
