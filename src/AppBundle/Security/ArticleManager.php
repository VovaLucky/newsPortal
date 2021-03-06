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
        $this->setSimilarArticles($article, $similar);
        $this->dbManager->addArticle($article);
    }

    public function deleteArticle(int $id)
    {
        $article = $this->getArticleById($id);
        if ($article != null) {
            $this->dbManager->deleteArticle($article);
        }
    }

    public function updateArticle(
        int $id,
        Category $category,
        User $user,
        string $title,
        string $image,
        string $text,
        array $similar
    ) {
        $article = $this->getArticleById($id);
        $article->setCategory($category);
        $article->setAuthor($user);
        $article->setTitle($title);
        $article->setImage($image);
        $article->setText($text);
        $this->setSimilarArticles($article, $similar);
        $this->dbManager->updateArticle($article);
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

    private function setSimilarArticles(Article $article, array $similar)
    {
        $similar = array_unique($similar);
        $similarNews = [];
        foreach ($similar as $articleId) {
            if ($articleId != null) {
                $similarNews[] = $this->getArticleById($articleId);
            }
        }
        $article->setSimilarArticles($similarNews);
    }
}