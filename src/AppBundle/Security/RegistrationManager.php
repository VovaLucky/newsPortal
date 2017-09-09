<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\DataBaseManager;

class RegistrationManager
{
    private $dbManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->dbManager = new DataBaseManager($doctrine);
    }


    public function tryToAddUser(string $email, string $password, string $repeatPassword, bool $isSubscribe): bool
    {
        if (!$this->isDataCorrect($email, $password, $repeatPassword))
        {
            return false;
        }

        $this->dbManager->addUser($email, $password, $isSubscribe);
        return true;
    }

    private function isDataCorrect(string $email, string $password, string $repeatPassword): bool
    {
        if (!$this->isPasswordMatch($password, $repeatPassword))
        {
            return false;
        }

        if($this->dbManager->isUserExist($email))
        {
            return false;
        }

        return true;
    }


    private function isPasswordMatch(string $password, string $repeatPassword): bool
    {
        return ($password == $repeatPassword);
    }
}