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

class EditController extends Controller
{
    /**
     * @Route("/edit/article/{page}", name="editArticle", requirements={"page": "\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function editArticleAction(ArticleManager $articleManager, CategoryManager $categoryManager, int $page)
    {
        return $this->render('news/editing/pageEdit.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categoryManager->getAllCategories(),
            'articles' => $articleManager->getAllArticles(),
            'type' => 'news',
            'typeCategory' => 'newsByCategory',
            'editArticle' => $articleManager->getArticleById($page)
        ]);
    }

    /**
     * @Route("/edit/article/{page}", name="editArticlePost", requirements={"page": "\d+"})
     * @Method("POST")
     */
    public function editArticlePostAction(
        Request $request,
        ArticleManager $articleManager,
        CategoryManager $categoryManager,
        RegistrationManager $registrationManager,
        int $page
    ) {
        $categoryName = $request->request->get('Category');
        $userId = $request->request->get('UserId');
        $title = $request->request->get('Title');
        $image = $request->request->get('Image');
        $text = $request->request->get('Text');
        $similar = $request->request->get('Similar');

        $category = $categoryManager->getCategoryByName($categoryName);
        $user = $registrationManager->getUserById($userId);
        $articleManager->updateArticle($page, $category, $user, $title, $image, $text, $similar);
        return $this->redirectToRoute('news');
    }
}