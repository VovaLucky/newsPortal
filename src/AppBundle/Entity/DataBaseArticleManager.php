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

    public function getCategoryByName(string $name):? Category
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Category')
            ->findOneBy(['name' => $name]);
    }

    public function getSubCategories(?int $category): array
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Category')
            ->findBy(['parent' => $category], ['name' => 'ASC']);
    }

    public function getArticleById(int $id):? Article
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Article')
            ->findOneBy(['id' => $id]);
    }

    public function getArticles(?int $category, string $criteria): array
    {
        $repository = $this->db->getRepository('AppBundle\Entity\Article');
        if ($category == null) {
            return $repository->findBy(
                [],
                [$criteria => 'DESC']
            );
        } else {
            return $repository->findBy(
                ['category' => $category],
                [$criteria => 'DESC']
            );
        }
    }

    public function increaseView(Article $article)
    {
        $article->increaseView();
        $this->db->persist($article);
        $this->db->flush();
    }
}