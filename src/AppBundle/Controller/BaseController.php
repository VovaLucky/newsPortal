<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    /**
     * @Route("/articles", name="articles")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function articlesAction(Request $request)
    {


        return $this->render('news/articles.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @Route("/news", name="news")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function newsPageAction(Request $request)
    {


        return $this->render('news/newsPage.html.twig', ['user' => $this->getUser()]);
    }
}