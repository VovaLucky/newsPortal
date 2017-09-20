<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Security\RegistrationManager;
use AppBundle\Security\ActivateManager;
use AppBundle\Security\EmailManager;

class RegistrationController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registrationAction(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        \Swift_Mailer $mailer
    ) {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('articles');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = new RegistrationManager($this->getDoctrine(), $passwordEncoder);
            $manager->addUser($user);
            if ($this->sendEmail($mailer, $user)) {
                return $this->redirectToRoute('homepage');
            }
        }
        return $this->render('form/registration.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(true, true)
        ]);
    }

    /**
     * @Route("/verifyEmail", name="verifyEmail")
     * @Method("GET")
     */
    public function verifyEmailAction(Request $request)
    {
        $token = $request->query->get('token');
        $manager = new ActivateManager($this->getDoctrine());
        if (($token !== null) && ($manager->isTokenCorrect($token))) {
            $manager->activateUser($token);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/error.html.twig');
    }

    private function sendEmail(\Swift_Mailer $mailer, User $user): bool
    {
        $body = $this->renderView(
            'email/activate.html.twig',
            ['token' => $user->getUserKey()->getToken()]
        );
        return EmailManager::sendMail($mailer, $user, 'Verify email', $body);
    }
}