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

        // clean out wccplayers without stats
        $em = $this->getDoctrine()->getManager();
        foreach ($players as $player) {
            if (sizeof($player['wccstats']) == 0) {
                $em->remove($player['wccplayer']);
            }
        }
        $em->flush();

        return $this->render('ClanmanagerBundle:Wccplayer:index.html.twig', array('players' => $players));
    }

    /**
     * @Route("/wccplayer/{profile}", name="wccplayer_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($profile) {
        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Wccplayer');
        $wccplayer = $repository->findOneByProfile($profile);
        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Wccstats');
        $wccstats = $repository->findByWccplayer($wccplayer);

        $player['wccplayer'] = $wccplayer;

        $player['wccstats'] = array();
        foreach ($wccstats as $stats) {
            $p = array();
            $p['info'] = json_decode($stats->getJson(), true);
            $p['wccstats'] = $stats;
            $player['wccstats'][] = $p;
        }
        foreach ($player['wccstats'] as $stats) {
            
        }


        return $this->render('ClanmanagerBundle:Wccplayer:view.html.twig', array('player' => $player));
    }

    /**
     * @Route("/wccplayer/json/{profile}", name="wccplayer_json")
     * @Security("has_role('ROLE_USER')")
     */
    public function jsonAction($profile) {

        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Wccplayer');
        $wccplayer = $repository->findOneByProfile($profile);
        $repository = $this->getDoctrine()->getRepository('ClanmanagerBundle:Wccstats');
        //$wccstats = $repository->findOneByWccplayer($wccplayer);
        $query = $repository->createQueryBuilder('ws')
                ->where('ws.wccplayer = :wccplayer')
                ->andWhere('ws.createdAt > :now')
                ->orderBY('ws.createdAt', 'DESC')
                //->setParameters(array('wccplayer' => $wccplayer, 'now' => '20150909080000'))
                ->setParameters(array('wccplayer' => $wccplayer, 'now' => date("YmdHis", strtotime("-2 hours"))))
                ->setMaxResults(1)
                ->getQuery();
        $wccstats = $query->getResult();
        if ($wccstats) {
            $response = new JsonResponse();
            $response->setData(json_decode($wccstats[0]->getJson()));
            return $response; ////CHANGEME////
        }

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        //$doc->loadHTMLFile("/srv/www/htdocs/clanmanager/EQ88GX8QR.html");
        $doc->loadHTMLFile("http://www.warclans.com/coc-player/" . $profile);
        libxml_use_internal_errors(false);
        $doc->preserveWhiteSpace = false;

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
            $key = trim(str_replace(array("army-icon", "no-icon", "active", "-icon", "top-lvl", "-"), "", $troopsnode->getAttribute("class")));
            if ($key)
                $player['troops'][$key] = $troopsnode->nodeValue;
        }

        $player['achievements'] = array();
        $achievements = $xpath->query("//div[@class='achievement-head']");
        foreach ($achievements as $node) {
            $player['achievements'][strtolower(str_replace(" ", "", $node->childNodes->item(1)->textContent))] = stristr(trim($node->childNodes->item(5)->textContent), ":") ? str_replace(" ", "", trim(explode(":", $node->childNodes->item(5)->textContent)[1])) : str_replace(" ", "", trim(explode("/", $node->childNodes->item(5)->textContent)[0]));
        }

        $player['village'] = array();

        $villagebuildings = $xpath->query("//div[@class='village-buildings']");

        $player['village']['wall'] = array();
        $walls = $xpath->query("//div[@class='walls']");
        foreach ($walls as $wall) {
            $key = explode(" ", trim(str_replace(array("background-position:", "; width: 25px; height: 50px;", "px", "-"), "", $wall->getAttribute("style"))))[1];
            $key = $key / 50 + 1;
            if ($key) {
                if (isset($player['village']['wall'][$key]))
                    $player['village']['wall'][$key] ++;
                else
                    $player['village']['wall'][$key] = 1;
            }
        }

        $values = array();
        $values[408][0] = array('townhall', 5);
        $values[510][0] = array('townhall', 6);
        $values[612][0] = array('townhall', 7);
        $values[714][0] = array('townhall', 8);
        $values[816][0] = array('townhall', 9);
        $values[918][0] = array('townhall', 10);
        $values[306][97] = array('laboratory', 3);
        $values[204][97] = array('laboratory', 4);
        $values[408][97] = array('laboratory', 5);
        $values[510][97] = array('laboratory', 6);
        $values[612][97] = array('laboratory', 7);
        $values[714][97] = array('laboratory', 8);
        $values[129][194] = array('camp', 2);
        $values[258][194] = array('camp', 3);
        $values[387][194] = array('camp', 4);
        $values[516][194] = array('camp', 5);
        $values[645][194] = array('camp', 6);
        $values[774][194] = array('camp', 7);
        $values[903][194] = array('camp', 8);
        $values[152][291] = array('clancastle', 3);
        $values[228][291] = array('clancastle', 4);
        $values[304][291] = array('clancastle', 5);
        $values[380][291] = array('clancastle', 6);
        $values[456][291] = array('clancastle', 7);
        $values[693][291] = array('buildershut', 0);
        $values[742][291] = array('barbarianking', 0);
        $values[818][291] = array('archerqueen', 0);
        $values[76][388] = array('barracks', 2);
        $values[228][388] = array('barracks', 4);
        $values[304][388] = array('barracks', 5);
        $values[380][388] = array('barracks', 6);
        $values[456][388] = array('barracks', 7);
        $values[532][388] = array('barracks', 8);
        $values[608][388] = array('barracks', 9);
        $values[684][388] = array('barracks', 10);
        $values[76][485] = array('archertower', 2);
        $values[228][485] = array('archertower', 4);
        $values[304][485] = array('archertower', 5);
        $values[380][485] = array('archertower', 6);
        $values[456][485] = array('archertower', 7);
        $values[532][485] = array('archertower', 8);
        $values[608][485] = array('archertower', 9);
        $values[684][485] = array('archertower', 10);
        $values[760][485] = array('archertower', 11);
        $values[836][485] = array('archertower', 12);
        $values[912][485] = array('archertower', 13);
        $values[76][582] = array('cannon', 2);
        $values[152][582] = array('cannon', 3);
        $values[228][582] = array('cannon', 4);
        $values[304][582] = array('cannon', 5);
        $values[380][582] = array('cannon', 6);
        $values[456][582] = array('cannon', 7);
        $values[532][582] = array('cannon', 8);
        $values[608][582] = array('cannon', 9);
        $values[684][582] = array('cannon', 10);
        $values[760][582] = array('cannon', 11);
        $values[836][582] = array('cannon', 12);
        $values[912][582] = array('cannon', 13);
        $values[76][679] = array('airdefense', 2);
        $values[152][679] = array('airdefense', 3);
        $values[228][679] = array('airdefense', 4);
        $values[304][679] = array('airdefense', 5);
        $values[380][679] = array('airdefense', 6);
        $values[456][679] = array('airdefense', 7);
        $values[532][679] = array('airdefense', 8);
        $values[769][679] = array('xbow', 2);
        $values[845][679] = array('xbow', 3);
        $values[921][679] = array('xbow', 4);
        $values[76][776] = array('goldmine', 2);
        $values[152][776] = array('goldmine', 3);
        $values[228][776] = array('goldmine', 4);
        $values[304][776] = array('goldmine', 5);
        $values[380][776] = array('goldmine', 6);
        $values[456][776] = array('goldmine', 7);
        $values[532][776] = array('goldmine', 8);
        $values[608][776] = array('goldmine', 9);
        $values[684][776] = array('goldmine', 10);
        $values[760][776] = array('goldmine', 11);
        $values[836][776] = array('goldmine', 12);
        $values[76][873] = array('goldstorage', 2);
        $values[228][873] = array('goldstorage', 4);
        $values[304][873] = array('goldstorage', 5);
        $values[380][873] = array('goldstorage', 6);
        $values[532][873] = array('goldstorage', 8);
        $values[608][873] = array('goldstorage', 9);
        $values[684][873] = array('goldstorage', 10);
        $values[760][873] = array('goldstorage', 11);
        $values[943][873] = array('inferno', 2);
        $values[992][873] = array('inferno', 3);
        $values[76][970] = array('darkbarracks', 2);
        $values[152][970] = array('darkbarracks', 3);
        $values[228][970] = array('darkbarracks', 4);
        $values[304][970] = array('darkbarracks', 5);
        $values[380][970] = array('darkbarracks', 6);
        $values[623][970] = array('spellfactory', 2);
        $values[699][970] = array('spellfactory', 3);
        $values[775][970] = array('spellfactory', 4);
        $values[851][970] = array('spellfactory', 5);
        $values[76][1067] = array('wizardtower', 2);
        $values[152][1067] = array('wizardtower', 3);
        $values[228][1067] = array('wizardtower', 4);
        $values[304][1067] = array('wizardtower', 5);
        $values[380][1067] = array('wizardtower', 6);
        $values[456][1067] = array('wizardtower', 7);
        $values[532][1067] = array('wizardtower', 8);
        $values[721][1067] = array('darkelixerdrill', 2);
        $values[797][1067] = array('darkelixerdrill', 3);
        $values[873][1067] = array('darkelixerdrill', 4);
        $values[949][1067] = array('darkelixerdrill', 5);
        $values[1025][1067] = array('darkelixerdrill', 6);
        $values[76][1164] = array('mortar', 2);
        $values[152][1164] = array('mortar', 3);
        $values[228][1164] = array('mortar', 4);
        $values[304][1164] = array('mortar', 5);
        $values[380][1164] = array('mortar', 6);
        $values[532][1164] = array('mortar', 7);
        $values[456][1164] = array('mortar', 8);
        $values[721][1164] = array('darkelixerstorage', 2);
        $values[797][1164] = array('darkelixerstorage', 3);
        $values[873][1164] = array('darkelixerstorage', 4);
        $values[949][1164] = array('darkelixerstorage', 5);
        $values[1025][1164] = array('darkelixerstorage', 6);
        $values[76][1261] = array('elixercollector', 2);
        $values[152][1261] = array('elixercollector', 3);
        $values[228][1261] = array('elixercollector', 4);
        $values[304][1261] = array('elixercollector', 5);
        $values[380][1261] = array('elixercollector', 6);
        $values[456][1261] = array('elixercollector', 7);
        $values[532][1261] = array('elixercollector', 8);
        $values[608][1261] = array('elixercollector', 9);
        $values[684][1261] = array('elixercollector', 10);
        $values[760][1261] = array('elixercollector', 11);
        $values[836][1261] = array('elixercollector', 12);
        $values[76][1358] = array('elixerstorage', 2);
        $values[304][1358] = array('elixerstorage', 5);
        $values[380][1358] = array('elixerstorage', 6);
        $values[456][1358] = array('elixerstorage', 7);
        $values[608][1358] = array('elixerstorage', 9);
        $values[684][1358] = array('elixerstorage', 10);
        $values[760][1358] = array('elixerstorage', 11);
        $values[988][1358] = array('darkspellfactory', 2);
        $values[1064][1358] = array('darkspellfactory', 3);
        $values[547][1455] = array('airsweeper', 1);
        $values[596][1455] = array('airsweeper', 2);
        $values[645][1455] = array('airsweeper', 3);
        $values[694][1455] = array('airsweeper', 4);
        $values[743][1455] = array('airsweeper', 5);

        $buildings = $xpath->query("//div[@class='buildings']");
        $coords = array();
        foreach ($buildings as $building) {
            $coords[] = explode(" ", trim(str_replace(array("background-position: ", "width: ", "height: ", "px", ";", "-"), "", $building->getAttribute("style"))));
        }

        //echo"<pre>";
        foreach ($coords as $coord) {
            //echo implode(",", $coord);
            //echo isset($values[$coord[0]][$coord[1]]) ? "=" . $values[$coord[0]][$coord[1]][0] . ":" . $values[$coord[0]][$coord[1]][1] : "";
            //echo "<br>";

            if (isset($values[$coord[0]][$coord[1]])) {
                $bld = 1;
                if (isset($player['village'][$values[$coord[0]][$coord[1]][0]][$values[$coord[0]][$coord[1]][1]]))
                    $player['village'][$values[$coord[0]][$coord[1]][0]][$values[$coord[0]][$coord[1]][1]] ++;
                else
                    $player['village'][$values[$coord[0]][$coord[1]][0]][$values[$coord[0]][$coord[1]][1]] = 1;
            } else {
                $this->addFlash('notice', 'missing coords: ' . $coord[0] . "," . $coord[1]);
            }
        }
        //print_r($coords);
        //echo"</pre>";
        //exit;


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
