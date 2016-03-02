<?php

namespace Neox\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NeoxUserBundle:Default:index.html.twig');
    }

    /**
     * Страница личного кабинета
     *
     * @return string
     */
    public function cabinetAction()
    {
        return $this->render('default/UserBundle/cabinet.html.twig');
    }

    /**
     * Страница авторизации
     *
     * @return string
     */
    public function loginAction()
    {
        return $this->render('default/UserBundle/login.html.twig');
    }

}
