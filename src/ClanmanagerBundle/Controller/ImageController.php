<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ImageController extends Controller {

    /**
     * @Route("/image", name="image")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {

        $images = array();
        $images[] = "/web/images/images/testocr.png";
        
        return $this->render('ClanmanagerBundle:Image:index.html.twig', array('images' => $images));
    }

}
