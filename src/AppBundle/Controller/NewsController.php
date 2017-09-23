<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\ArticleManager;

class NewsController extends Controller
{
    /**
     * @Route("/news", name="news")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function newsAction(Request $request, ArticleManager $manager)
    {
        $categories = $manager->getSubCategories(null);
        $articles = $manager->getArticlesByDate(null);
        return $this->render('news/articles.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories,
            'articles' => $articles,
            'type' => 'news',
            'typeCategory' => 'newsByCategory'
        ]);
    }

    /**
     * @Route("/news/{category}", name="newsByCategory")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function articlesByCategoryAction(Request $request, ArticleManager $manager, string $category)
    {
        $category = $manager->getCategoryByName($category);
        if ($category == null) {
            throw $this->createNotFoundException('The page does not exist.');
        }
        $categories = $manager->getSubCategories($category->getId());
        $articles = $manager->getArticlesByDate($category->getId());
        return $this->render('news/articles.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories,
            'articles' => $articles,
            'type' => 'news',
            'typeCategory' => 'newsByCategory'
        ]);
    }

    /**
     * @Route("/newspage/{page}", name="newsPage", requirements={"page": "\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function newsPageAction(Request $request, ArticleManager $manager, int $page)
    {
        $article = $manager->getArticleById($page);
        if ($article == null) {
            throw $this->createNotFoundException('The page does not exist.');
        }
        $manager->increaseView($article);
        $categories = $manager->getSubCategories($article->getCategory()->getId());
        return $this->render('news/newsPage.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories,
            'article' => $article,
            'type' => 'news',
            'typeCategory' => 'newsByCategory'
        ]);
    }
}