<?php

namespace AppBundle\Entity;

use Doctrine\Common\Persistence\ManagerRegistry;

class DataBaseManager
{
    private $db;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->db = $doctrine->getManager();
    }

    public function addUser(User $user)
    {
        $this->db->persist($user);
        $this->db->flush();

        $userKey = new UserKey($user, 'registration', $this->getToken(), $this->getTime());
        $this->db->persist($userKey);
        $this->db->flush();

        $user->setUserKey($userKey);
        $this->db->flush();
    }

    public function getUser(string $email):? User
    {
        return $this->db
            ->getRepository('AppBundle\Entity\User')
            ->findOneBy(['email' => $email]);
    }

    public function isUserExist(string $email): bool
    {
        return null !== $this->getUser($email);
    }

    private function getToken(): string
    {
        return 'token';
    }

    private function getTime(): int
    {
        return time();
    }
}