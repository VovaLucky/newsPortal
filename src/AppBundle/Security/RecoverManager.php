<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\DataBaseManager;
use AppBundle\Entity\User;

class RecoverManager
{
    private $dbManager;
    private $encoder;
    const MAX_INTERVAL = 86400;

    public function __construct(ManagerRegistry $doctrine, UserPasswordEncoderInterface $encoder)
    {
        $this->dbManager = new DataBaseManager($doctrine);
        $this->encoder = $encoder;
    }

    public function resetPassword(string $email):? User
    {
        if ($this->dbManager->isUserExist($email)){
            $user = $this->dbManager->getUser($email);
            if ($user->getUserKey() === null){
                $this->dbManager->resetPassword($user);
                return $user;
            }
        }
        return null;
    }

    public function updatePassword(string $token, string $password)
    {
        $user = $this->dbManager->getUserByToken($token);
        $this->encodePassword($user, $password);
        $this->dbManager->updatePassword($user);
    }

    public function isDataCorrect(string $token, string $password, string $repeatPassword): bool
    {
        if (($this->isTokenCorrect($token)) && ($this->isPasswordMatch($password, $repeatPassword))){
            return true;
        } else {
            return false;
        }
    }

    public function isTokenCorrect(string $token)
    {
        if (($token !== null) && ($this->dbManager->isUserExistByToken($token))){
            if ($this->dbManager->isRecoverToken($token)){
                return true;
            }
        }
        return false;
    }

    public function isTimeCorrect($token): bool
    {
        $userKey = $this->dbManager->getUserByToken($token)->getUserKey();
        $time = $userKey->getTime()->getTimestamp();
        $now = new \DateTime();
        $interval = $now->getTimestamp() - $time;
        if ($interval < self::MAX_INTERVAL){
            return true;
        } else {
            return false;
        }
    }

    private function isPasswordMatch(string $password, string $repeatPassword): bool
    {
        return ($password == $repeatPassword);
    }

    private function encodePassword(User $user, string $password)
    {
        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);
    }
}