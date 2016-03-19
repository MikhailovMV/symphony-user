<?php

namespace Neox\UserBundle\Controller;

use Doctrine\ORM\EntityManager;
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
                'first_options' => array('label' => 'Пароль'),
                'second_options' => array('label' => 'Повтор пароля'),
            ))
            ->add('save', SubmitType::class, array('label' => 'Отправить'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Сохранения пользователя в БД
            
            // Шифрование пароля
            $password = $this->get('security.password_encoder')
                             ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('neox_user_registered');
        }

        return $this->render(
            'default/UserBundle/register.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Страница уведомления об успешной регистрации
     *
     * @return string
     */
    public function registeredAction()
    {
        return $this->render(
            'default/UserBundle/registered.html.twig'
        );

    }
}
