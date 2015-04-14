<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {
        return $this->render('ClanmanagerBundle:Default:index.html.twig');
    }

    /**
     * @Route("/admin")
     */
    public function adminAction() {
        return new Response('Admin page!');
    }

}
