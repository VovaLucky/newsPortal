<?php

namespace AppBundle\Security;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\DataBaseArticleManager;
use AppBundle\Entity\Article;
use AppBundle\Entity\Category;

class ArticleManager
{
    private $dbManager;
    const BY_DATE = 'date';
    const BY_VIEW = 'view';

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->dbManager = new DataBaseArticleManager($doctrine);
    }

    public function getCategoryByName(string $name):? Category
    {
        return $this->dbManager->getCategoryByName($name);
    }

    public function getSubCategories(?int $category): array
    {
        return $this->dbManager->getSubCategories($category);
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

    public function increaseView(Article $article)
    {
        $this->dbManager->increaseView($article);
    }
}