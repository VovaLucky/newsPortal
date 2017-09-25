<?php

namespace AppBundle\Controller\Editing;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\ArticleManager;
use AppBundle\Security\CategoryManager;
use AppBundle\Security\RegistrationManager;

class AddController extends Controller
{
    /**
     * @Route("/add/article", name="addArticle")
     * @Method("GET")
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function addArticleAction(ArticleManager $articleManager, CategoryManager $categoryManager)
    {
        return $this->render('news/editing/page.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categoryManager->getAllCategories(),
            'articles' => $articleManager->getAllArticles(),
            'type' => 'news',
            'typeCategory' => 'newsByCategory'
        ]);
    }

    /**
     * @Route("/add/article/post", name="addArticlePost")
     * @Method("POST")
     */
    public function addArticlePostAction(
        Request $request,
        ArticleManager $articleManager,
        CategoryManager $categoryManager,
        RegistrationManager $registrationManager
    ) {
        $categoryName = $request->request->get('Category');
        $title = $request->request->get('Title');
        $image = $request->request->get('Image');
        $text = $request->request->get('Text');
        $userId = $request->request->get('UserId');
        $similar = $request->request->get('Similar');

        $category = $categoryManager->getCategoryByName($categoryName);
        $user = $registrationManager->getUserById($userId);
        $articleManager->addArticle($category, $user, $title, $image, $text, $similar);
        return $this->redirectToRoute('news');
    }

    /**
     * @Route("/add/category", name="addCategory")
     * @Method("GET")
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function addCategoryAction(CategoryManager $categoryManager)
    {
        return $this->render('news/editing/category.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categoryManager->getAllCategories(),
            'articles' => [],
            'type' => 'news',
            'typeCategory' => 'newsByCategory',
            'name' => ''
        ]);
    }

    /**
     * @Route("/add/category/post", name="addCategoryPost")
     * @Method("POST")
     */
    public function addCategoryPostAction(Request $request, CategoryManager $categoryManager)
    {
        $name = $request->request->get('CategoryName');
        if ($categoryManager->isCategoryExist($name)) {
            return $this->render('news/editing/category.html.twig', [
                'user' => $this->getUser(),
                'categories' => $categoryManager->getAllCategories(),
                'articles' => [],
                'type' => 'news',
                'typeCategory' => 'newsByCategory',
                'name' => $name,
                'error' => true
            ]);
        }
        $parent = $request->request->get('Parent');
        $categoryManager->addCategory($name, $parent);
        return $this->redirectToRoute('addArticle');
    }
}