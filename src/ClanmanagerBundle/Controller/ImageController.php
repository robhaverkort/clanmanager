<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller {

    /**
     * @Route("/image", name="image")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {

        $images = array();
        $images[] = "/web/images/images/testocr.png";
        $images[] = "/web/images/images/clan1.jpg";
        $images[] = "/web/images/images/clan2.jpg";

        return $this->render('ClanmanagerBundle:Image:index.html.twig', array('images' => $images));
    }

    /**
     * @Route("/image/{image_id}", name="image_view")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewAction($image_id) {
        return $this->render('ClanmanagerBundle:Image:view.html.twig', array('image_id' => $image_id));
    }

    /**
     * @Route("/image/display/{image_id}/{attack_id}/{part_id}", name="image_display")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function displayAction($image_id, $attack_id, $part_id) {

        $filename = "/srv/www/htdocs/clanmanager/web/images/images/testocr.png";

        $image = imagecreatefrompng($filename);

        switch ($part_id) {

            case 0:
                $dest = imagecreatetruecolor(40, 28);
                imagecopy($dest, $image, 0, 0, 204, 224 + $attack_id * 60, 38, 28); // my clan
                break;
            case 1:
                $dest = imagecreatetruecolor(40, 28);
                imagecopy($dest, $image, 0, 0, 626, 224 + $attack_id * 60, 38, 24); // other clan
                break;
            case 2:
                $dest = imagecreatetruecolor(28, 18);
                imagecopy($dest, $image, 0, 0, 180, 252 + $attack_id * 60, 28, 18); // other clan
                break;
            case 3:
                $dest = imagecreatetruecolor(28, 18);
                imagecopy($dest, $image, 0, 0, 605, 252 + $attack_id * 60, 28, 18); // other clan
                break;
            case 4:
                $dest = imagecreatetruecolor(60, 20);
                imagecopy($dest, $image, 0, 0, 215, 252 + $attack_id * 60, 60, 20); // other clan
                break;
            case 5:
                $dest = imagecreatetruecolor(60, 20);
                imagecopy($dest, $image, 0, 0, 640, 252 + $attack_id * 60, 60, 20); // other clan
                break;
            case 6:
                $dest = imagecreatetruecolor(140, 16);
                imagecopy($dest, $image, 0, 0, 862, 256 + $attack_id * 60, 140, 16); // other clan
                break;
        }

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', 'image/png');
        $response->headers->set('Content-Disposition', 'inline; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));
        $response->setContent(imagepng($dest, NULL, 0, PNG_NO_FILTER));
        return $response;
    }

}
