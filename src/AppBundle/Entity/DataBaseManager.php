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

    public function getUserByToken(string $token):? User
    {
        $userKey = $this->db
            ->getRepository('AppBundle\Entity\UserKey')
            ->findOneBy(['token' => $token]);
        if ($userKey) {
            return $userKey->getUser();
        } else {
            return null;
        }
    }

    public function isUserExistByToken(string $token): bool
    {
        return null !== $this->getUserByToken($token);
    }

    public function activateUser(User $user)
    {
        $user->setIsActive(true);
        $userKey = $user->getUserKey();
        $this->db->remove($userKey);
        $this->db->flush();
    }

    public function resetPassword(User $user)
    {
        $userKey = new UserKey($user, self::RECOVER_TYPE, $this->getToken(), $this->getTime());
        $user->setUserKey($userKey);
        $this->db->persist($user);
        $this->db->persist($userKey);
        $this->db->flush();
    }

    public function updatePassword(User $user)
    {
        $userKey = $user->getUserKey();
        $this->db->remove($userKey);
        $this->db->persist($user);
        $this->db->flush();
    }

    public function isRegistrationToken(string $token): bool
    {
        $userKey = $this->getUserByToken($token)->getUserKey();
        return $userKey->getType() === self::REGISTRATION_TYPE;
    }

    public function isRecoverToken(string $token): bool
    {
        $userKey = $this->getUserByToken($token)->getUserKey();
        return $userKey->getType() === self::RECOVER_TYPE;
    }

    private function getToken(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(self::BYTE_COUNT));
    }

    private function getTime(): \DateTime
    {
        return new \DateTime();
    }
}