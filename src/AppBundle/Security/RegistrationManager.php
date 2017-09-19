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

    public function addUser(User $user)
    {
        $this->encodePassword($user);
        $user->setRole(self::DEFAULT_ROLE);
        $user->setIsActive(false);
        $this->dbManager->addUser($user);
    }

    private function encodePassword(User $user)
    {
        $encodedPassword = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($encodedPassword);
    }
}