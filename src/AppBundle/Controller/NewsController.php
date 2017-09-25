<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Security\ArticleManager;
use AppBundle\Security\CategoryManager;

class NewsController extends Controller
{
    /**
     * @Route("/news", name="news")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function newsAction(ArticleManager $articleManager, CategoryManager $categoryManager)
    {
        return $this->render('news/articles.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categoryManager->getSubCategories(null),
            'articles' => $articleManager->getArticlesByDate(null),
            'type' => 'news',
            'typeCategory' => 'newsByCategory'
        ]);
    }

    /**
     * @Route("/news/{category}", name="newsByCategory")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function articlesByCategoryAction(
        ArticleManager $articleManager,
        CategoryManager $categoryManager,
        string $category
    ) {
        $category = $categoryManager->getCategoryByName($category);
        if ($category == null) {
            throw $this->createNotFoundException('The page does not exist.');
        }
        return $this->render('news/articles.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categoryManager->getSubCategories($category->getId()),
            'articles' => $articleManager->getArticlesByDate($category->getId()),
            'type' => 'news',
            'typeCategory' => 'newsByCategory'
        ]);
    }

    /**
     * @Route("/newspage/{page}", name="newsPage", requirements={"page": "\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function newsPageAction(ArticleManager $articleManager, CategoryManager $categoryManager, int $page)
    {
        $article = $articleManager->getArticleById($page);
        if ($article == null) {
            throw $this->createNotFoundException('The page does not exist.');
        }
        $articleManager->increaseView($article);
        return $this->render('news/newsPage.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categoryManager->getSubCategories($article->getCategory()->getId()),
            'article' => $article,
            'type' => 'news',
            'typeCategory' => 'newsByCategory',
            'edit' => true
        ]);
    }
}