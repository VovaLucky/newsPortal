<?php

namespace AppBundle\Controller;

use AppBundle\Security\ActivateManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;
use AppBundle\Security\RegistrationManager;

class RegistrationController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     * @Method("GET")
     */
    public function registrationAction(Request $request)
    {
        return $this->render('form/registration.html.twig');
    }

    /**
     * @Route("/register", name="register")
     * @Method("POST")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $email = $request->request->get('Email');
        $password = $request->request->get('Password');
        $repeatPassword = $request->request->get('RepeatPassword');
        $isSubscribe = ($request->request->get('Subscribe') === 'on');

        $manager = new RegistrationManager($this->getDoctrine(), $passwordEncoder);
        if ($manager->isDataCorrect($email, $password, $repeatPassword)){
            $user = $manager->addUser($email, $password, $isSubscribe);
            $this->sendEmail($mailer, $user);
            return $this->redirectToRoute('homepage');
        } else {
            return $this->redirectToRoute('registration');
        }
    }

    /**
     * @Route("/verifyEmail", name="verifyEmail")
     */
    public function verifyEmailAction(Request $request)
    {
        $token = $request->query->get('token');
        $manager = new ActivateManager($this->getDoctrine());
        if ($manager->activateUser($token)){
            return $this->redirectToRoute('homepage');
        }
        return $this->redirectToRoute('homepage');
    }

    private function sendEmail(\Swift_Mailer $mailer, User $user)
    {
        $body = $this->renderView(
            'email/activate.html.twig',
            ['token' => $user->getUserKey()->getToken()]
        );
        $message = (new \Swift_Message('Verify email'))
            ->setFrom(['dryg-vova@yandex.ru' => 'NewsPortal'])
            ->setTo($user->getUsername())
            ->setBody($body, 'text/html');
        $mailer->send($message);
    }
}