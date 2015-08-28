<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \DOMDocument;
use \DOMXPath;

class WarclanscomController extends Controller {

    /**
     * @Route("/warclanscom", name="warclanscom")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        return $this->render('ClanmanagerBundle:Warclanscom:index.html.twig');
    }


}
