<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\DataBaseManager\ArticleDBManager;
use AppBundle\Entity\Article;
use AppBundle\Entity\Category;

class ArticleManager
{
    private $dbManager;
    const BY_DATE = 'date';
    const BY_VIEW = 'view';

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->dbManager = new ArticleDBManager($doctrine);
    }

    public function addArticle(
        Category $category,
        User $user,
        string $title,
        string $image,
        string $text,
        array $similar
    ) {
        $article = new Article($category, $user, $title, $image, $text);
        $similarNews = [];
        foreach ($similar as $articleId) {
            if ($articleId != null) {
                $similarNews[] = $this->getArticleById($articleId);
            }
        }
        $article->setSimilarArticles($similarNews);
        $this->dbManager->addArticle($article);
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