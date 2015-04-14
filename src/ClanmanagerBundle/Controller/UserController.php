<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends Controller {

    /**
     * @Route("/user", name="user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:User');
        $users = $repository->findAll();
        return $this->render('ClanmanagerBundle:User:index.html.twig', array('users' => $users));
    }

    /**
     * @Route("/user/{user_id}", name="user_view")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewAction($user_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:User');
        $user = $repository->find($user_id);

        return $this->render('ClanmanagerBundle:User:view.html.twig', array('user' => $user));
    }

    /**
     * @Route("/user/edit/{user_id}", name="user_edit")
     * @Security("has_role('ROLE_USER')")
     * XXX@Security("is_granted('user_view',user)")
     */
    public function editAction(Request $request, $user_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:User');
        $user = $repository->find($user_id);

        if (false === $this->get('security.authorization_checker')->isGranted('view', $user)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('user_edit', array('user_id' => $user->getId()))
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form['plainPassword']->getData() == $form['plainPassword2']->getData()) {
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $form['plainPassword']->getData());
                $user->setPassword($encoded);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'nieuw password: ' . $encoded);
            } else {
                $this->addFlash('notice', 'password niet veranderd');
               
            }
            return $this->render('ClanmanagerBundle:User:edit.html.twig', array('user' => $user, 'form' => $form->createView()));
        }

        return $this->render('ClanmanagerBundle:User:edit.html.twig', array('user' => $user, 'form' => $form->createView()));
    }

}
