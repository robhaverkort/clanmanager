<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ClanmanagerBundle\Entity\Clan;

class ClanController extends Controller {

    /**
     * @Route("/clan", name="clan")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Clan');
        $clans = $repository->findAll();
        return $this->render('ClanmanagerBundle:Clan:index.html.twig', array('clans' => $clans));
    }

    /**
     * @Route("/clan/{clan_id}", name="clan_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($clan_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Clan');
        $clan = $repository->find($clan_id);
        $wcs = $clan->getWarclans();
        $warclan_ids = array();
        if (sizeof($wcs)) {
            for ($n = sizeof($wcs); $n >= sizeof($wcs) - 10; $n--) {
                $warclan_ids[] = $wcs[$n - 1]->getId();
            }
        }

        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Membership');
        $members = $repository->findByClan($clan);

        $wars = array();
        $warclans = array_reverse(array_slice($clan->getWarclans()->toArray(), -11));
        foreach ($warclans as $wpkey => $warclan) {
            $w = array();
            foreach ($warclan->getWarplayers() as $warplayer) {
                foreach ($warplayer->getAttacks() as $attkey => $attack) {
                    $w['players'][$warplayer->getPlayer()->getId()]['attacks'][$attkey]['stars'] = $attack->getStars();
                }
            }
            $wars[] = $w;
        }

        $players = array();
        foreach ($members as $member) {
            if (!$member->getStop()) {
                $p = array();
                $p['membership'] = $member;
                $p['player'] = $member->getPlayer();
                $p['profile'] = $member->getPlayer()->getProfile();
                $p['wccplayer'] = $member->getPlayer()->getWccplayer();
                $players[] = $p;
            }
        }

        usort($players, function($a, $b) {
            return $b['wccplayer']->getOffenseweight() - $a['wccplayer']->getOffenseweight();
        });

        return $this->render('ClanmanagerBundle:Clan:view.html.twig', array('clan' => $clan, 'warclan_ids' => $warclan_ids, 'players' => $players, 'wars' => $wars));
    }

    /**
     * @Route("/clan_new", name="clan_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request) {
        $clan = new Clan();
        $form = $this->createFormBuilder($clan)
                ->setAction($this->generateUrl('clan_new'))
                ->add('tag', 'text')
                ->add('name', 'text')
                ->add('save', 'submit', array('label' => 'Create Clan'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($clan);
            $em->flush();
            $this->addFlash('notice', 'Your changes were saved!');

            return $this->redirectToRoute('clan');
        }

        return $this->render('ClanmanagerBundle:Clan:new.html.twig', array('form' => $form->createView()));
    }

}
