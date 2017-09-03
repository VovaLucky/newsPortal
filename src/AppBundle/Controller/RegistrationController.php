<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     * @Method("GET")
     */
    public function registrationAction(Request $request)
    {
        return $this->render('default/registration.html.twig');
    }

    /**
     * @Route("/register", name="register")
     * @Method("POST")
     */
    public function registerAction(Request $request)
    {

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/resetPassword", name="resetPassword")
     * @Method("GET")
     */
    public function resetPasswordAction(Request $request)
    {
        return $this->render('default/resetPassword.html.twig');
    }

    /**
     * @Route("/reset", name="reset")
     * @Method("POST")
     */
    public function resetAction(Request $request)
    {

        return $this->redirectToRoute('homepage');
    }

}