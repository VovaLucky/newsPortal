<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\User;
use AppBundle\Entity\DataBaseManager;

class SubscribeManager
{
    private $dbManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->dbManager = new DataBaseManager($doctrine);
    }

    public function changeSubscribeStatus(int $id)
    {
        $user = $this->dbManager->getUserById($id);
        $this->dbManager->changeSubscribe($user);
    }
}