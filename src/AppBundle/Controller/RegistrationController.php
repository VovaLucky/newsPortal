<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\RegistrationManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     * @Method("GET")
     */
    public function registrationAction(Request $request)
    {
        return $this->render('default/formRegistration.html.twig');
    }

    /**
     * @Route("/register", name="register")
     * @Method("POST")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $email = $request->request->get('Email');
        $password = $request->request->get('Password');
        $repeatPassword = $request->request->get('RepeatPassword');
        $isSubscribe = ($request->request->get('Subscribe') === 'on');
        $manager = new RegistrationManager($this->getDoctrine(), $passwordEncoder);
        if ($manager->tryToAddUser($email, $password, $repeatPassword, $isSubscribe))
        {
            return $this->redirectToRoute('homepage');
        }
        else
        {
            return $this->redirectToRoute('registration');
        }
    }

    /**
     * @Route("/recoverPassword", name="recoverPassword")
     * @Method("GET")
     */
    public function resetPasswordAction(Request $request)
    {
        return $this->render('default/recoverPassword.html.twig');
    }

    /**
     * @Route("/recover", name="recover")
     * @Method("POST")
     */
    public function resetAction(Request $request)
    {

        return $this->redirectToRoute('homepage');
    }

}