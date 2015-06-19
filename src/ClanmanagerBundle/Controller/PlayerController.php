<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ClanmanagerBundle\Entity\Player;
use ClanmanagerBundle\Entity\Membership;

class PlayerController extends Controller {

    /**
     * @Route("/player", name="player")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Player');
        $players = $repository->findAll();
        return $this->render('ClanmanagerBundle:Player:index.html.twig', array('players' => $players));
    }

    /**
     * @Route("/player/{player_id}", name="player_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($player_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Player');
        $player = $repository->find($player_id);

        $clan = $this->getDoctrine()->getRepository('ClanmanagerBundle:Clan')->findByPlayer($player);

        return $this->render('ClanmanagerBundle:Player:view.html.twig', array('player' => $player, 'clan' => $clan));
    }

    /**
     * @Route("/player/new/{clan_id}", name="player_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request, $clan_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Clan');
        $clan = $repository->find($clan_id);

        $player = new Player();
        $form = $this->createFormBuilder($player)
                ->setAction($this->generateUrl('player_new', array('clan_id' => $clan_id)))
                ->add('tag', 'text', array('attr' => array('size' => 10)))
                ->add('name', 'text', array('attr' => array('size' => 16)))
                ->add('th', 'text', array('attr' => array('size' => 3, 'maxlength' => 2)))
                ->add('start', 'date', array('mapped' => false, 'data' => new \DateTime(), 'attr' => array()))
                ->add('save', 'submit', array('label' => 'Add Player'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $membership = new Membership();
            $membership->setClan($clan);
            $membership->setPlayer($player);
            $membership->setStart($form['start']->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($membership);
            $em->persist($player);
            $em->flush();
            $this->addFlash('notice', 'Your changes were saved!');

            return $this->redirectToRoute('clan_view', array('clan_id' => $clan_id));
        }

        return $this->render('ClanmanagerBundle:Player:new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/player/stop/{membership_id}", name="player_stop")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function stopAction(Request $request, $membership_id) {
        $em = $this->getDoctrine()->getManager();
        $membership = $em->getRepository('ClanmanagerBundle:Membership')->find($membership_id);

        $form = $this->createFormBuilder()
                ->add('stop', 'date', array('mapped' => false, 'data' => new \DateTime(), 'attr' => array()))
                ->add('save', 'submit', array('label' => 'Stop Membership'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $membership->setStop($form['stop']->getData());
            $em->persist($membership);
            $em->flush();
            $this->addFlash('notice', 'Your changes were saved!');
            return $this->redirectToRoute('clan_view', array('clan_id' => $membership->getClan()->getId()));
        }

        return $this->render('ClanmanagerBundle:Player:stop.html.twig', array('membership' => $membership, 'form' => $form->createView()));
    }

    /**
     * @Route("/player/delete/{player_id}", name="player_delete")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($player_id) {

        $em = $this->getDoctrine()->getManager();
        $player = $em->getRepository('ClanmanagerBundle:Player')->find($player_id);
        $memberships = $em->getRepository('ClanmanagerBundle:Membership')->findByPlayer($player);
        foreach ($memberships as $membership)
            $em->remove($membership);
        $em->remove($player);
        $em->flush();

        return $this->redirectToRoute('clan');
        //return $this->render('ClanmanagerBundle:Clan:index.html.twig');
    }

}
