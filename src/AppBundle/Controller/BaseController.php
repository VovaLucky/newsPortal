<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\ArticleManager;

class BaseController extends Controller
{
    /**
     * @Route("/articles", name="articles")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function articlesAction(Request $request, ArticleManager $manager)
    {
        $categories = $manager->getCategories(null);
        $articles = $manager->getArticlesByDate(null);
        return $this->render('news/articles.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories,
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{page}", name="news", requirements={"page": "\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function newsPageAction(Request $request, ArticleManager $manager, int $page)
    {
        $article = $manager->getArticleById($page);
        if ($article == null) {
            throw $this->createNotFoundException('The page does not exist.');
        }
        $categories = $manager->getCategories($article->getCategory()->getId());
        return $this->render('news/newsPage.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories,
            'article' => $article
        ]);
    }
}