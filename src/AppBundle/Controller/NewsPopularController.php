<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\ArticleManager;

class NewsPopularController extends Controller
{
    /**
     * @Route("/popular", name="popular")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function popularAction(Request $request, ArticleManager $manager)
    {
        $categories = $manager->getSubCategories(null);
        $articles = $manager->getArticlesByView(null);
        return $this->render('news/articles.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories,
            'articles' => $articles,
            'type' => 'popular',
            'typeCategory' => 'popularByCategory'
        ]);
    }

    /**
     * @Route("/popular/{category}", name="popularByCategory")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function popularByCategoryAction(Request $request, ArticleManager $manager, string $category)
    {
        $category = $manager->getCategoryByName($category);
        if ($category == null) {
            throw $this->createNotFoundException('The page does not exist.');
        }
        $categories = $manager->getSubCategories($category->getId());
        $articles = $manager->getArticlesByView($category->getId());
        return $this->render('news/articles.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories,
            'articles' => $articles,
            'type' => 'popular',
            'typeCategory' => 'popularByCategory'
        ]);
    }
}