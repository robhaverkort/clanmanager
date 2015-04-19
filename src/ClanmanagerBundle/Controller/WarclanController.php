<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class WarclanController extends Controller {

    /**
     * @Route("/warclan", name="warclan")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warclan');
        $warclans = $repository->findAll();
        return $this->render('ClanmanagerBundle:Warclan:index.html.twig', array('warclans' => $warclans));
    }

    /**
     * @Route("/warclan/{warclan_id}", name="warclan_view")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewAction($warclan_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warclan');
        $warclan = $repository->find($warclan_id);
        return $this->render('ClanmanagerBundle:Warclan:view.html.twig', array('warclan' => $warclan));
    }

}
