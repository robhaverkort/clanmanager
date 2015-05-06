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
        return $this->render('ClanmanagerBundle:Clan:view.html.twig', array('clan' => $clan));
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
