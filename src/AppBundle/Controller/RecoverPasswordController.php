<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\RecoverManager;
use AppBundle\Entity\User;
use AppBundle\Security\EmailManager;

class RecoverPasswordController extends Controller
{
    /**
     * @Route("/recoverPassword", name="recoverPassword")
     * @Method("GET")
     */
    public function resetPasswordAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('news');
        }
        return $this->render('form/recoverPassword.html.twig');
    }

    /**
     * @Route("/recover", name="recover")
     * @Method("POST")
     */
    public function resetAction(Request $request, RecoverManager $manager, \Swift_Mailer $mailer)
    {
        $email = $request->request->get('Email');
        if ($email !== null) {
            $user = $manager->resetPassword($email);
            if (($user !== null) && ($this->sendEmail($mailer, $user))) {
                return $this->redirectToRoute('homepage');
            }
        }
        return $this->render('default/error.html.twig');
    }

    /**
     * @Route("/password", name="password")
     * @Method("GET")
     */
    public function passwordAction(Request $request, RecoverManager $manager)
    {
        $token = $request->query->get('token');
        if ($token !== null) {
            if (($manager->isTokenCorrect($token)) && ($manager->isTimeCorrect($token))) {
                return $this->render('form/newPassword.html.twig', ['token' => $token]);
            }
        }
        return $this->render('default/error.html.twig');
    }

    /**
     * @Route("/setPassword", name="setPassword")
     * @Method("POST")
     */
    public function setPasswordAction(Request $request, RecoverManager $manager)
    {
        $token = $request->request->get('Token');
        $password = $request->request->get('Password');
        $repeatPassword = $request->request->get('RepeatPassword');

        if ($manager->isDataCorrect($token, $password, $repeatPassword)) {
            $manager->updatePassword($token, $password);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/error.html.twig');
    }

    private function sendEmail(\Swift_Mailer $mailer, User $user): bool
    {
        $body = $this->renderView(
            'email/recover.html.twig',
            ['token' => $user->getUserKey()->getToken()]
        );
        return EmailManager::sendMail($mailer, $user, 'Recover password', $body);
    }
}