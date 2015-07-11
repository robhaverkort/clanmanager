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

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTMLFile("/srv/www/htdocs/clanmanager/NDQPM3WQ0");
        libxml_use_internal_errors(false);
        $doc->preserveWhiteSpace = false;

        $titles = $doc->getElementsByTagName("title");
        $title = $titles->length;
        $title = $titles->item(0);
        //$title = $doc->saveHTML($title);
        $title = $title->nodeValue;

        $xpath = new DOMXPath($doc);
        //$nlist = $xpath->query("//a[@rel='nofollow']");
        $elements = $xpath->query("//ul[@class='clan-list player-list']");

        $text = "";
        foreach ($elements as $element) {
            $text .= $element->nodeName . "\n";
            $text .= $element->nodeValue . "\n";
        }

        $nodes = $element->childNodes;
        foreach ($nodes as $node) {
            $text .= $node->nodeValue . "####";
        }

        $players = $element->childNodes;

        return $this->render('ClanmanagerBundle:Warclanscom:index.html.twig', array('title' => $title, 'players' => $players, 'text' => $text));
    }

}
