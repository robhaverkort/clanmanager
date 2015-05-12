<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClanmanagerBundle\Entity\Player;
use ClanmanagerBundle\Entity\Clan;
use ClanmanagerBundle\Entity\Membership;
use ClanmanagerBundle\Entity\Warplayer;
use Doctrine\ORM\EntityRepository;

class WarplayerController extends Controller {

    /**
     * @Route("/warplayer", name="warplayer")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warplayer');
        $warplayers = $repository->findAll();
        return $this->render('ClanmanagerBundle:Warplayer:index.html.twig', array('warplayers' => $warplayers));
    }

    /**
     * @Route("/warplayer/war/{war_id}", name="warplayer_war")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function warAction($war_id) {
        $war = $this->getDoctrine()->getRepository('ClanmanagerBundle:War')->find($war_id);
        $warclans = $this->getDoctrine()->getRepository('ClanmanagerBundle:Warclan')->findByWar($war);

        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warplayer');
        $warplayers = $repository->findByWarclan($warclans[0]);
        return $this->render('ClanmanagerBundle:Warplayer:index.html.twig', array('warplayers' => $warplayers));
    }

    /**
     * @Route("/warplayer/warclan/{warclan_id}", name="warplayer_warclan")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function warclanAction($warclan_id) {
        $warclan = $this->getDoctrine()->getRepository('ClanmanagerBundle:Warclan')->find($warclan_id);

        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warplayer');
        $warplayers = $repository->findByWarclan($warclan);
        return $this->render('ClanmanagerBundle:Warplayer:index.html.twig', array('warplayers' => $warplayers));
    }

    /**
     * @Route("/warplayer/new/{warclan_id}", name="warplayer_new")
     * @Security("has_role('ROLE_ADMIN')")c
     */
    public function newAction(Request $request, $warclan_id) {
        $warclan = $this->getDoctrine()->getRepository('ClanmanagerBundle:Warclan')->find($warclan_id);

        if ($warclan->getClan()->getId() == 1) {
            $form = $this->createFormBuilder()
                    ->setAction($this->generateUrl('warplayer_new', array('warclan_id' => $warclan_id)))
                    ->add('warclan', 'hidden', array('data' => $warclan_id))
                    ->add('rank', 'text', array('attr' => array('size' => 4, 'maxlength' => 3)))
                    ->add('name', 'entity', array(
                        'class' => 'ClanmanagerBundle:Player',
                        'property' => 'name',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('p')
                                    ->join('p.memberships','m')
                                    ->where('m.clan=:clan_id')
                                    ->andWhere('m.stop IS NULL')
                                    ->setParameter('clan_id',1)
                                    ->orderBy('p.name', 'ASC');
                        }))
                    ->add('th', 'text', array('attr' => array('size' => 3, 'maxlength' => 2)))
                    ->add('save', 'submit', array('label' => 'Add Player'))
                    ->getForm();
        } else {
            $form = $this->createFormBuilder()
                    ->setAction($this->generateUrl('warplayer_new', array('warclan_id' => $warclan_id)))
                    ->add('warclan', 'hidden', array('data' => $warclan_id))
                    ->add('rank', 'text', array('attr' => array('size' => 4, 'maxlength' => 3)))
                    ->add('name', 'text')
                    ->add('th', 'text', array('attr' => array('size' => 3, 'maxlength' => 2)))
                    ->add('save', 'submit', array('label' => 'Add Player'))
                    ->getForm();
        }

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if ($warclan->getClan()->getId() == 1) {
                $player = $form['name']->getData();
            } else {
                $player = new Player();
                $player->setName($form['name']->getData());
                $em->persist($player);

                $membership = new Membership();
                $membership->setPlayer($player);
                $membership->setClan($warclan->getClan());
                $em->persist($membership);
            }

            $warplayer = new Warplayer();
            $warplayer->setPlayer($player);
            $warplayer->setWarclan($warclan);
            $warplayer->setRank($form['rank']->getData());
            $warplayer->setTh($form['th']->getData());
            $em->persist($warplayer);

            $em->flush();
            $this->addFlash('notice', 'Your changes were saved!');
            return $this->redirectToRoute('warclan_view', array('warclan_id' => $warclan_id));
        }

        return $this->render('ClanmanagerBundle:Warplayer:new.html.twig', array('form' => $form->createView()));
    }

}
