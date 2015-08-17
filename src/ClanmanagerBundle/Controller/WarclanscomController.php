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
        //$doc->loadHTMLFile("/srv/www/htdocs/clanmanager/NDQPM3WQ0.html"); 
        $doc->loadHTMLFile("http://www.warclans.com/coc-clan/NDQPM3WQ0");
        libxml_use_internal_errors(false);
        $doc->preserveWhiteSpace = false;

        $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;

        $xpath = new DOMXPath($doc);
        $playerlist_ul = $xpath->query("//ul[@class='clan-list player-list']")->item(0);
        $text = "";
        //$text .= "nodeName:" . $playerlist_ul->nodeName . "\n";
        //$text .= "nodeValue:" . $playerlist_ul->nodeValue . "\n";

        $nodes = $playerlist_ul->childNodes;
        foreach ($nodes as $node) {
            if ($node->hasChildNodes()) {
                $text .= $node->nodeValue . "####";

                $player['nodeValue'] = $node->nodeValue;
                $player['rank'] = trim($node->childNodes->item(1)->childNodes->item(1)->nodeValue);
                $player['level'] = trim($node->childNodes->item(1)->childNodes->item(5)->nodeValue);
                $player['profile'] = split("/", trim($node->childNodes->item(1)->childNodes->item(7)->childNodes->item(1)->childNodes->item(1)->attributes->getNamedItem("href")->textContent))[4];
                $player['name'] = trim($node->childNodes->item(1)->childNodes->item(7)->childNodes->item(1)->childNodes->item(1)->nodeValue);
                $player['role'] = trim($node->childNodes->item(1)->childNodes->item(7)->childNodes->item(3)->childNodes->item(1)->nodeValue);
                $player['score'] = trim($node->childNodes->item(3)->childNodes->item(3)->nodeValue);

                $playerinfo = new DOMDocument();
                libxml_use_internal_errors(true);
                $playerinfo->loadHTML($node->ownerDocument->saveHTML( $node ));
                $xpath = new DOMXPath($playerinfo);
                //$text .= ">>>" . $xpath->query("//span[@class='score']")->item(0)->nodeValue . "<<<";
 
                $player['rank'] = $xpath->query("//span[@class='num']")->item(0)->nodeValue;
                $player['level'] = $xpath->query("//span[@class='level']")->item(0)->nodeValue;

                $player['score'] = $xpath->query("//span[@class='score']")->item(0)->nodeValue;
                
                $players[] = $player;
            }
        }

        //$players = $playerlist_ul->childNodes;

        return $this->render('ClanmanagerBundle:Warclanscom:index.html.twig', array('title' => $title, 'players' => $players, 'text' => $text));
    }

}
