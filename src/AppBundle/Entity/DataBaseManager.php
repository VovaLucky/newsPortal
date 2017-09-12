<?php

namespace AppBundle\Entity;

use Doctrine\Common\Persistence\ManagerRegistry;

class DataBaseManager
{
    private $db;
    const BYTE_COUNT = 32;
    const REGISTRATION_TYPE = 'registration';
    const RECOVER_TYPE = 'recover';

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->db = $doctrine->getManager();
    }

    public function addUser(User $user)
    {
        $userKey = new UserKey($user, self::REGISTRATION_TYPE, $this->getToken(), $this->getTime());
        $user->setUserKey($userKey);
        $this->db->persist($user);
        $this->db->persist($userKey);
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
        return bin2hex(openssl_random_pseudo_bytes(self::BYTE_COUNT));
    }

    private function getTime(): int
    {
        return time();
    }
}