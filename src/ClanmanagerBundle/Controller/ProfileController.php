<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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

}
