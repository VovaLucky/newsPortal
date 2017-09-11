<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\DataBaseManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationManager
{
    private $dbManager;
    private $encoder;

    public function __construct(ManagerRegistry $doctrine, UserPasswordEncoderInterface $encoder)
    {
        $this->dbManager = new DataBaseManager($doctrine);
        $this->encoder = $encoder;
    }

    private function addUser(string $email, string $password, bool $isSubscribe)
    {
        $user = new User($email, $password, 'ROLE_USER', $isSubscribe);
        $this->encodePassword($user);
        $this->dbManager->addUser($user);
    }

    public function tryToAddUser(string $email, string $password, string $repeatPassword, bool $isSubscribe): bool
    {
        if (!$this->isDataCorrect($email, $password, $repeatPassword)) {
            return false;
        } else {
            $this->addUser($email, $password, $isSubscribe);
            return true;
        }
    }

    private function isDataCorrect(string $email, string $password, string $repeatPassword): bool
    {
        if (!$this->isPasswordMatch($password, $repeatPassword)) {
            return false;
        }
        if($this->dbManager->isUserExist($email)) {
            return false;
        }
        return true;
    }

    private function isPasswordMatch(string $password, string $repeatPassword): bool
    {
        return ($password == $repeatPassword);
    }

    private function encodePassword(User $user)
    {
        $encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
    }
}