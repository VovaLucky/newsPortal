<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="isSubscribe", type="boolean")
     */
    private $isSubscribe;

    /**
     * @ORM\OneToOne(targetEntity="UserKey", mappedBy="user")
     */
    private $userKey;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="author")
     */
    private $article;

    public function __construct(string $email, string $password, string $role, bool $isSubscribe)
    {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->isSubscribe = $isSubscribe;
        $this->isActive = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setUsername(string $email)
    {
        $this->email = $email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setRole(string $role)
    {
        $this->role = $role;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsSubscribe(bool $isSubscribe)
    {
        $this->isSubscribe = $isSubscribe;
    }

    public function getIsSubscribe(): bool
    {
        return $this->isSubscribe;
    }

    public function setUserKey(UserKey $userKey)
    {
        $this->userKey = $userKey;
    }

    public function getUserKey(): UserKey
    {
        return $this->userKey;
    }

    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }
}
