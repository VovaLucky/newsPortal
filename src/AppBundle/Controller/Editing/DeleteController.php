<?php

namespace AppBundle\Controller\Editing;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\ArticleManager;

class DeleteController extends Controller
{
    /**
     * @Route("/delete/article/{page}", name="deleteArticle", requirements={"page": "\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function deleteArticleAction(ArticleManager $articleManager, int $page)
    {
        $articleManager->deleteArticle($page);
        return $this->redirectToRoute('news');
    }
}