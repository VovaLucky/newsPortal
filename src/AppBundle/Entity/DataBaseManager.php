<?php

namespace AppBundle\Entity;

use Doctrine\Common\Persistence\ManagerRegistry;

class DataBaseManager
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function addUser(string $email, string $password, bool $isSubscribe)
    {
        $db = $this->doctrine->getManager();
        $user = new User($email, $password, $isSubscribe, 'ROLE_USER');
        $db->persist($user);
        $db->flush();
        $userKey = new UserKey($user, 'registration', 'token', time());
        $db->persist($userKey);
        $db->flush();
        $user->setUserKey($userKey);
        $db->flush();

//        $db = $this->doctrine->getManager();
//        $account = new Account('active', 'local');
//        $db->persist($account);
//        $db->flush();
//        $localUser = new User($login, $this->getPasswordHash($password));
//        $localUser->setAccount($account);
//        $db->persist($localUser);
//        $db->flush();
//        $account->setUser($localUser);
//        $db->flush();
    }

    public function getUser(string $email):? User
    {
        return $this->doctrine
            ->getManager()
            ->getRepository('AppBundle\Entity\User')
            ->findOneBy(['email' => $email]);
    }

    public function isUserExist(string $email): bool
    {
        return null !== $this->getUser($email);
    }


}