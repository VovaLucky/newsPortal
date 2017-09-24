<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Security\SubscribeManager;

class SubscribeController extends Controller
{
    /**
     * @Route("/subscribe", name="subscribe")
     * @Method("POST")
     */
    public function subscribeAction(Request $request, SubscribeManager $manager)
    {
        $id = $request->request->get('id');
        $manager->changeSubscribeStatus($id);
        return new Response(json_encode([]));
    }
}