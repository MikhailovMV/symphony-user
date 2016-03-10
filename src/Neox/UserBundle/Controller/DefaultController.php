<?php

namespace Neox\UserBundle\Controller;

use Neox\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * Страница регистрации
     *
     * @return string
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, array(
                'invalid_message' => 'The password fields must match.',
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('task_success');
        }

        return $this->render(
            'default/UserBundle/register.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

}
