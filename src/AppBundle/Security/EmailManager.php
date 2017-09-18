<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Exception;

class EmailManager
{
    const ADDRESS = 'dryg-vova@yandex.ru';

    public static function sendMail(\Swift_Mailer $mailer, User $user, string $subject, string $body): bool
    {
        try{
            $message = (new \Swift_Message($subject))
                ->setFrom(['dryg-vova@yandex.ru' => 'NewsPortal'])
                ->setTo($user->getUsername())
                ->setBody($body, 'text/html');
            $mailer->send($message);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}