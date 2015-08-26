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

class WccplayerController extends Controller {

    /**
     * @Route("/wccplayer", name="wccplayer")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTMLFile("/srv/www/htdocs/clanmanager/EQ88GX8QR.html");
        //$doc->loadHTMLFile("http://www.warclans.com/coc-player/EQ88GX8QR");
        libxml_use_internal_errors(false);
        $doc->preserveWhiteSpace = false;

        $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;

        $xpath = new DOMXPath($doc);
        //$player_info = $xpath->query("//div[@class='plyer-content']")->item(0);
        $player_info = $xpath->query("//div[contains(concat(' ',normalize-space(@class),' '),' player-info ')]")->item(0);

        $player = array();

        $player['level'] = $xpath->query("//div[@class='level']")->item(0)->textContent;
        $player['name'] = $xpath->query("//h1[@class='title']")->item(0)->textContent;
        $player['clanprofile'] = $xpath->query("//span[@class='members']")->item(0)->getAttribute("href");
        $player['clanname'] = $xpath->query("//span[@class='members']")->item(0)->getAttribute("title");
        $player['score'] = $xpath->query("//span[@class='score']")->item(0)->textContent;
        $player['clan_info'] = $xpath->query("//div[@class='clan-info']")->item(0)->textContent;
        $player['goldgrab'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(0)->childNodes->item(1)->textContent);
        $player['elixergrab'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(2)->childNodes->item(1)->textContent);
        $player['darkelixergrab'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(4)->childNodes->item(1)->textContent);
        $player['wonbattles'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(6)->childNodes->item(1)->textContent);
        $player['defenseswon'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(8)->childNodes->item(1)->textContent);
        $player['warhero'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(10)->childNodes->item(1)->textContent);
        $player['goldinwar'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(12)->childNodes->item(1)->textContent);
        $troopswrap = $xpath->query("//span[contains(concat(' ',normalize-space(@class),' '),' army-icon ')]");
        $player['troops'] = array();
        foreach ($troopswrap as $troopsnode) {
            $key = trim(str_replace(array("army-icon", "no-icon", "active", "-icon", "top-lvl"), "", $troopsnode->getAttribute("class")));
            if ($key)
                $player['troops'][$key] = $troopsnode->nodeValue;
        }

        return $this->render('ClanmanagerBundle:Wccplayer:index.html.twig', array('title' => $title, 'player' => $player));
    }

    /**
     * @Route("/wccplayer/{profile}", name="wccplayer_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($profile) {

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        //$doc->loadHTMLFile("/srv/www/htdocs/clanmanager/EQ88GX8QR.html");
        $doc->loadHTMLFile("http://www.warclans.com/coc-player/" . $profile);
        libxml_use_internal_errors(false);
        $doc->preserveWhiteSpace = false;

        $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;

        $xpath = new DOMXPath($doc);
        //$player_info = $xpath->query("//div[@class='plyer-content']")->item(0);
        $player_info = $xpath->query("//div[contains(concat(' ',normalize-space(@class),' '),' player-info ')]")->item(0);

        $player = array();

        $player['playerinfo'] = array();
        $player['playerinfo']['level'] = $xpath->query("//div[@class='level']")->item(0)->textContent;
        $player['playerinfo']['playername'] = $xpath->query("//h1[@class='title']")->item(0)->textContent;
        $player['playerinfo']['clanprofile'] = $xpath->query("//span[@class='members']")->item(0)->getAttribute("href");
        $player['playerinfo']['clanname'] = $xpath->query("//span[@class='members']")->item(0)->getAttribute("title");
        $player['playerinfo']['score'] = $xpath->query("//span[@class='score']")->item(0)->textContent;
        //$player['playerinfo']['clan_info'] = $xpath->query("//div[@class='clan-info']")->item(0)->textContent;

        $player['claninfo'] = array();
        $player['claninfo']['goldgrab'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(0)->childNodes->item(1)->textContent);
        $player['claninfo']['elixergrab'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(2)->childNodes->item(1)->textContent);
        $player['claninfo']['darkelixergrab'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(4)->childNodes->item(1)->textContent);
        $player['claninfo']['wonbattles'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(6)->childNodes->item(1)->textContent);
        $player['claninfo']['defenseswon'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(8)->childNodes->item(1)->textContent);
        $player['claninfo']['warhero'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(10)->childNodes->item(1)->textContent);
        $player['claninfo']['goldinwar'] = str_replace(" ", "", $xpath->query("//div[@class='clan-info']")->item(0)->childNodes->item(1)->childNodes->item(12)->childNodes->item(1)->textContent);

        $player['troops'] = array();
        $troopswrap = $xpath->query("//span[contains(concat(' ',normalize-space(@class),' '),' army-icon ')]");
        foreach ($troopswrap as $troopsnode) {
            $key = trim(str_replace(array("army-icon", "no-icon", "active", "-icon", "top-lvl"), "", $troopsnode->getAttribute("class")));
            if ($key)
                $player['troops'][$key] = $troopsnode->nodeValue;
        }

        $player['achievements'] = array();

        $response = new Response($this->renderView('ClanmanagerBundle:Wccplayer:view.xml.twig', array('player' => $player)),200);
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }

}
