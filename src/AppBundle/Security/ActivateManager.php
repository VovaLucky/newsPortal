<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\DataBaseManager;
use Exception;

class ActivateManager
{
    private $dbManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->dbManager = new DataBaseManager($doctrine);
    }

    public function activateUser(string $token): bool
    {
        try{
            $user = $this->dbManager->getUserByToken($token);
            if ($user){
                $this->dbManager->activateUser($user);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}