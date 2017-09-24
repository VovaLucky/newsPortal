<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\DataBaseManager\ArticleDBManager;
use AppBundle\Entity\Article;

class ArticleManager
{
    private $dbManager;
    const BY_DATE = 'date';
    const BY_VIEW = 'view';

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->dbManager = new ArticleDBManager($doctrine);
    }

    public function getArticleById(int $id):? Article
    {
        return $this->dbManager->getArticleById($id);
    }

    public function getArticlesByDate(?int $category): array
    {
        return $this->dbManager->getArticles($category, self::BY_DATE);
    }

    public function getArticlesByView(?int $category): array
    {
        return $this->dbManager->getArticles($category, self::BY_VIEW);
    }

    public function getAllArticles(): array
    {
        return $this->dbManager->getAllArticles();
    }

    public function increaseView(Article $article)
    {
        $this->dbManager->increaseView($article);
    }
}