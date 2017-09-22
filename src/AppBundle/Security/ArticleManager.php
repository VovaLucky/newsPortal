<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\DataBaseArticleManager;
use AppBundle\Entity\Article;

class ArticleManager
{
    private $dbManager;
    const BY_DATE = 'date';
    const BY_VIEW = 'view';

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->dbManager = new DataBaseArticleManager($doctrine);
    }

    public function getCategories($category): array
    {
        return $this->dbManager->getCategories($category);
    }

    public function getArticlesByDate($category): array
    {
        if ($category == null){
            return $this->dbManager->getAllArticles(self::BY_DATE);
        }
        return $this->dbManager->getArticles($category, self::BY_DATE);
    }

    public function getArticlesByView($category): array
    {
        if ($category == null){
            return $this->dbManager->getAllArticles(self::BY_VIEW);
        }
        return $this->dbManager->getArticles($category, self::BY_VIEW);
    }

    public function getArticleById(int $id):? Article
    {
        return $this->dbManager->getArticleById($id);
    }
}