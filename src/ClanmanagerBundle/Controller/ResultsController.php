<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ResultsController extends Controller {

    /**
     * @Route("/results/war", name="results_war")
     * @Security("has_role('ROLE_USER')")
     */
    public function warAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:War');
        $wars = $repository->findAll();
        return $this->render('ClanmanagerBundle:Results:war.html.twig', array('wars' => $wars));
    }


}
