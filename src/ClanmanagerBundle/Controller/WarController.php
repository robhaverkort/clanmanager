<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ClanmanagerBundle\Entity\War;

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
     * @Route("/war/new", name="war_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request) {

        $war = new War();

        $form = $this->createFormBuilder($war)
                ->setAction($this->generateUrl('war_new'))
                ->add('save', 'submit', array('label' => 'Add Player'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->addFlash('notice', 'Your changes were saved!');

            return $this->redirectToRoute('war');
        }
        return $this->redirectToRoute('war');
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
