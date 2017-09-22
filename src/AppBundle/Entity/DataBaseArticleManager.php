<?php

namespace AppBundle\Entity;

use Doctrine\Common\Persistence\ManagerRegistry;

class DataBaseArticleManager
{
    private $db;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->db = $doctrine->getManager();
    }

    public function getCategories($category): array
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Category')
            ->findBy(['parent' => $category], ['name' => 'ASC']);
    }

    public function getAllArticles(string $criteria): array
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Article')
            ->findBy([], [$criteria => 'DESC']);
    }

    public function getArticles($category, string $criteria): array
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Article')
            ->findBy(['category' => $category], [$criteria => 'DESC']);
    }

    public function getArticleById(int $id):? Article
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Article')
            ->findOneBy(['id' => $id]);
    }
}