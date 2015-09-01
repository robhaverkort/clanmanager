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
use Symfony\Component\HttpFoundation\JsonResponse;
use ClanmanagerBundle\Entity\Wccclan;
use ClanmanagerBundle\Entity\Wccplayer;
use ClanmanagerBundle\Entity\Wccstats;

class WccplayerController extends Controller {

    /**
     * @Route("/wccplayer", name="wccplayer")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {

        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Wccplayer');
        $wccplayers = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Wccstats');
        $players = array();
        foreach ($wccplayers as $wccplayer) {
            $player = array();
            $player['wccplayer'] = $wccplayer;
            $wccstats = $repository->findByWccplayer($wccplayer);
            $player['wccstats'] = $wccstats;
            $players[] = $player;
        }

        return $this->render('ClanmanagerBundle:Wccplayer:index.html.twig', array('players' => $players));
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
        $player['playerinfo']['profile'] = $profile;
        $player['playerinfo']['level'] = $xpath->query("//div[@class='level']")->item(0)->textContent;
        $player['playerinfo']['name'] = $xpath->query("//h1[@class='title']")->item(0)->textContent;
        $player['playerinfo']['clanprofile'] = explode("/", $xpath->query("//span[@class='members']")->item(0)->childNodes->item(1)->getAttribute("href"))[4];
        $player['playerinfo']['clanname'] = $xpath->query("//span[@class='members']")->item(0)->childNodes->item(1)->getAttribute("title");
        $player['playerinfo']['clanrole'] = $xpath->query("//span[@class='members']")->item(0)->childNodes->item(3)->textContent;
        $player['playerinfo']['league'] = str_replace(".png", "", explode("/", $xpath->query("//div[@class='player-legue-wrap']")->item(0)->childNodes->item(1)->getAttribute("src"))[5]);
        $player['playerinfo']['score'] = $xpath->query("//div[@class='player-legue-wrap']")->item(0)->childNodes->item(2)->textContent;
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
        $achievements = $xpath->query("//div[@class='achievement-head']");
        foreach ($achievements as $node) {
            $player['achievements'][strtolower(str_replace(" ", "", $node->childNodes->item(1)->textContent))] = stristr(trim($node->childNodes->item(5)->textContent), ":") ? str_replace(" ", "", trim(explode(":", $node->childNodes->item(5)->textContent)[1])) : str_replace(" ", "", trim(explode("/", $node->childNodes->item(5)->textContent)[0]));
        }

        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Wccclan');
        $wccclan = $repository->findOneByProfile($player['playerinfo']['clanprofile']);
        if (!$wccclan) {
            $wccclan = new Wccclan();
            $wccclan->setProfile($profile);
            $wccclan->setName($name);
            $em->persist($wccclan);
        }

        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Wccplayer');
        $wccplayer = $repository->findOneByProfile($player['playerinfo']['profile']);
        if (!$wccplayer) {
            $wccplayer = new Wccplayer();
            $wccplayer->setProfile($player['playerinfo']['profile']);
            $wccplayer->setName($player['playerinfo']['name']);
            $em->persist($wccplayer);
        }

        $wccstats = new Wccstats();
        $wccstats->setWccclan($wccclan);
        $wccstats->setWccplayer($wccplayer);
        $wccstats->setJson(json_encode($player));
        $em->persist($wccstats);

        $em->flush();

        // XML
        //$response = new Response($this->renderView('ClanmanagerBundle:Wccplayer:view.xml.twig', array('player' => $player)),200);
        //$response->headers->set('Content-Type', 'text/xml');
        // JSON
        $response = new JsonResponse();
        $response->setData($player);

        return $response;
    }

}
