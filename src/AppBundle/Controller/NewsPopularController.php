<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Security\ArticleManager;
use AppBundle\Security\CategoryManager;

class NewsPopularController extends Controller
{
    /**
     * @Route("/popular", name="popular")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function popularAction(ArticleManager $articleManager, CategoryManager $categoryManager)
    {
        return $this->render('news/articles.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categoryManager->getSubCategories(null),
            'articles' => $articleManager->getArticlesByView(null),
            'type' => 'popular',
            'typeCategory' => 'popularByCategory'
        ]);
    }

    /**
     * @Route("/popular/{category}", name="popularByCategory")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function popularByCategoryAction(
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
            'articles' => $articleManager->getArticlesByView($category->getId()),
            'type' => 'popular',
            'typeCategory' => 'popularByCategory'
        ]);
    }
}