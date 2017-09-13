<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecoverPasswordController extends Controller
{
    /**
     * @Route("/recoverPassword", name="recoverPassword")
     * @Method("GET")
     */
    public function resetPasswordAction(Request $request)
    {

        return $this->render('form/recoverPassword.html.twig');
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