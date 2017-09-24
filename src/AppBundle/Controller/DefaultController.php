<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(AuthenticationUtils $authUtils)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('news');
        }
        $error = $authUtils->getLastAuthenticationError();
        $email = $authUtils->getLastUsername();
        return $this->render('form/signIn.html.twig', [
            'email' => $email,
            'error' => $error
        ]);
    }
}
