<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\DataBaseManager;

class RegistrationManager
{
    private $dbManager;
    private $encoder;
    const DEFAULT_ROLE = 'ROLE_USER';

    public function __construct(ManagerRegistry $doctrine, UserPasswordEncoderInterface $encoder)
    {
        $this->dbManager = new DataBaseManager($doctrine);
        $this->encoder = $encoder;
    }

    public function addUser(string $email, string $password, bool $isSubscribe): User
    {
        $user = new User($email, $password, self::DEFAULT_ROLE, $isSubscribe);
        $this->encodePassword($user);
        $this->dbManager->addUser($user);
        return $user;
    }

    public function isDataCorrect(string $email, string $password, string $repeatPassword): bool
    {
        if ((!$this->isPasswordMatch($password, $repeatPassword)) ||
            ($this->dbManager->isUserExist($email))){
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