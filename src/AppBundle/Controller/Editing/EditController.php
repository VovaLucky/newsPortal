<?php

namespace AppBundle\Controller\Editing;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Security\ArticleManager;

class EditController extends Controller
{
    /**
     * @Route("/edit/article/{page}", name="editArticle", requirements={"page": "\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function editArticleAction(Request $request, ArticleManager $articleManager, int $page)
    {
        return $this->redirectToRoute('news');
    }
}