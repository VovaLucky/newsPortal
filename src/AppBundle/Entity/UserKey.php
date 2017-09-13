<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_keys")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserKeyRepository")
 */
class UserKey
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="userKey")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(name="type", type="string", length=30)
     */
    private $type;

    /**
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(name="time", type="integer")
     */
    private $time;

    public function __construct(User $user, string $type, string $token, int $time)
    {
        $this->user = $user;
        $this->type = $type;
        $this->token = $token;
        $this->time = $time;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setTime(int $time)
    {
        $this->time = $time;
    }

    public function getTime(): int
    {
        return $this->time;
    }
}
