<?php

namespace AppBundle\DataBaseManager;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\Article;

class ArticleDBManager
{
    private $db;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->db = $doctrine->getManager();
    }

    public function addArticle(Article $article)
    {
        $article->setDate($this->getTime());
        $this->db->persist($article);
        $this->db->flush();
    }

    public function deleteArticle(Article $article)
    {
        $this->db->remove($article);
        $this->db->flush();
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

    public function getAllArticles(): array
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Article')
            ->findBy([], ['title' => 'ASC']);
    }

    public function increaseView(Article $article)
    {
        $article->increaseView();
        $this->db->persist($article);
        $this->db->flush();
    }

    private function getTime(): \DateTime
    {
        return new \DateTime();
    }
}