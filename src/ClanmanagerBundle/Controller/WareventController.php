<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class WareventController extends Controller {

    /**
     * @Route("/warevent", name="warevent")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warevent');
        $warevents = $repository->findAll();
        return $this->render('ClanmanagerBundle:Warevent:index.html.twig', array('warevents' => $warevents));
    }

}
