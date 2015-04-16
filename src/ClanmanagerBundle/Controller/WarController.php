<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class WarController extends Controller {

    /**
     * @Route("/war", name="war")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:War');
        $wars = $repository->findAll();
        return $this->render('ClanmanagerBundle:War:index.html.twig', array('wars' => $wars));
    }

    /**
     * @Route("/war/{war_id}", name="war_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($war_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:War');
        $war = $repository->find($war_id);
        return $this->render('ClanmanagerBundle:War:view.html.twig', array('war' => $war));
    }

}
