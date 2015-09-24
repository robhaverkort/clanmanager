<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use ClanmanagerBundle\Form\Type\ProfileType;
use ClanmanagerBundle\Entity\Profile;

class ProfileController extends Controller {

    /**
     * @Route("/profile", name="profile")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Profile');
        $profiles = $repository->findAll();
        return $this->render('ClanmanagerBundle:Profile:index.html.twig', array('profiles' => $profiles));
    }

    /**
     * @Route("/profile/edit/{player_id}", name="profile_edit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, $player_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:Player');
        $player = $repository->find($player_id);
        $profile = $player->getProfile();

        if (!$profile) {
            $profile = new Profile();
        }

        $form = $this->createForm(new ProfileType(), $profile, array(
            'action' => $this->generateUrl('profile_edit', array('player_id' => $player_id))
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$profile->addPlayer($player); // doesnt work ????
            $em->persist($profile);
            $player->setProfile($profile);
            $em->persist($player);
            $em->flush();
            $this->addFlash('notice', 'profile changed');
            return $this->redirectToRoute('clan_view', array('clan_id' => 1));
        } else {
            $this->addFlash('notice', 'nothing changed');
        }

        return $this->render('ClanmanagerBundle:Profile:edit.html.twig', array('player' => $player, 'profile' => $profile, 'form' => $form->createView()));
    }

}
