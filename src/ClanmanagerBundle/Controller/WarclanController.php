<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Route("/warclan/comp/{warclan_id}", name="warclan_comp")
     * @Security("has_role('ROLE_USER')")
     */
    public function compAction($warclan_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warclan');
        $warclan = $repository->find($warclan_id);

        $comp = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($warclan->getWarplayers() as $warplayer) {
            $comp[$warplayer->getTh()]+=1;
        }

        return new Response($comp[10] . "/" . $comp[9] . "/" . $comp[8]);
    }

    /**
     * @Route("/warclan/stars/{warclan_id}", name="warclan_stars")
     * @Security("has_role('ROLE_USER')")
     */
    public function starsAction($warclan_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warclan');
        $warclan = $repository->find($warclan_id);

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $nrstars = 0;
            foreach ($warclan->getWarplayers() as $warplayer) {
                $stars = array(0);
                foreach ($warplayer->getDefends() as $warevent) {
                    $stars[] = $warevent->getStars();
                }
                $nrstars += max($stars);
            }
            $warclan->setStars($nrstars);
            $em = $this->getDoctrine()->getManager();
            //$em->persist($warclan);
            $em->flush();
        }

        return new Response($warclan->getStars());
    }

}
