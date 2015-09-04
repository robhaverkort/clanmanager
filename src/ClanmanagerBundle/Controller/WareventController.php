<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClanmanagerBundle\Entity\Warevent;
use ClanmanagerBundle\Entity\War;
use ClanmanagerBundle\Entity\WarplayerRepository;

class WareventController extends Controller {

    /**
     * @Route("/warevent", name="warevent")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:War');
        $war = $repository->createQueryBuilder('w')
                ->select('w')
                ->orderBy('w.start','DESC')
                //->setMaxResults(1)
                ->getQuery()
                ->getResult()[0];
        //dump($war);exit;
        return $this->redirectToRoute('warevent_view',array('war_id'=>$war->getId()));
        
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warevent');
        $warevents = $repository->findAll();
        return $this->render('ClanmanagerBundle:Warevent:index.html.twig', array('warevents' => $warevents));
    }

    /**
     * @Route("/warevent/{war_id}", name="warevent_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($war_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warevent');
        $warevents = $repository->findByWarId($war_id);
        return $this->render('ClanmanagerBundle:Warevent:index.html.twig', array('warevents' => $warevents));
    }

    /**
     * @Route("/warevent/new/{attacker_id}", name="warevent_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request, $attacker_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Warplayer');
        $attacker = $repository->find($attacker_id);
        $war = $attacker->getWarclan()->getWar();

        if ($war->getWarclans()[0] === $attacker->getWarclan()) {
            $defenders = $war->getWarclans()[1]->getWarplayers();
        } else {
            $defenders = $war->getWarclans()[0]->getWarplayers();
        }

        $att_clan = $attacker->getWarclan()->getClan();

        $warevent = new Warevent();

        $form = $this->createFormBuilder($warevent)
                ->setAction($this->generateUrl('warevent_new', array('attacker_id' => $attacker_id)))
                ->add('attacker', 'entity', array(
                    'class' => 'ClanmanagerBundle:Warplayer',
                    //'property' => 'id',
                    'data' => $attacker,
                    'disabled' => true
                ))
                ->add('defender', 'entity', array(
                    'class' => 'ClanmanagerBundle:Warplayer',
                    'choices' => $defenders,
                        //'property' => 'id',
                        //'label'=>'warclan',
                ))
                ->add('stars', 'choice', array('choices' => array(0, 1, 2, 3)))
                ->add('percent', 'text', array('attr' => array('size' => 3, 'maxlength' => 3)))
                ->add('time', 'time', array())
                ->add('save', 'submit', array('label' => 'Add Warevent'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $warevent->setAttacker($form['attacker']->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($warevent);
            $em->flush();
            return $this->redirectToRoute('war_view', array('war_id' => $war->getId()));
        }

        return $this->render('ClanmanagerBundle:Warevent:new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/warselect", name="warselect")
     * @Security("has_role('ROLE_USER')")
     */
    public function warselectAction(Request $request) {

        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('warselect'))
                ->add('war_id', 'entity', array(
                    'class' => 'ClanmanagerBundle:War',
                    'placeholder' => 'all wars',
                    'data' => '6 Red Onslaught - The Black Lodge'
                ))
                ->add('save', 'submit', array('label' => 'filter'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->redirectToRoute('warevent_view', array('war_id' => $form['war_id']->getData())); 
            //return $this->redirectToRoute('warevent_view', array('war_id' => $request->request->get('war_id')));
        }

        return $this->render('ClanmanagerBundle:Warevent:warselect.html.twig', array('form' => $form->createView()));
    }

}
