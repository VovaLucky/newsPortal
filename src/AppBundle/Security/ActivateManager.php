<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\DataBaseManager\UserDBManager;

class ActivateManager
{
    private $dbManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->dbManager = new UserDBManager($doctrine);
    }

    public function activateUser(string $token)
    {
        $user = $this->dbManager->getUserByToken($token);
        $this->dbManager->activateUser($user);
    }

    public function isTokenCorrect(string $token)
    {
        if ($this->dbManager->isUserExistByToken($token)) {
            if ($this->dbManager->isRegistrationToken($token)) {
                return true;
            }
        }
        return false;
    }
}