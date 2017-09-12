<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationController extends Controller
{
    /**
     * @Route("/authentication", name="authentication")
     * @Method("POST")
     */
    public function authenticationAction(Request $request)
    {

        return $this->redirectToRoute('articles');
    }
}