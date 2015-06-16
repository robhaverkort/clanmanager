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
     * @Route("/image/display/{image_id}", name="image_display")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function displayAction($image_id) {

        $filename = "/srv/www/htdocs/clanmanager/web/images/images/testocr.png";

        $image = imagecreatefrompng($filename);
        //$im_cropped = imagecrop($image, array(100,100,100,100));

        $dest = imagecreatetruecolor(38, 24);
        imagecopy($dest, $image, 0, 0, 204, 224, 38, 24); // my clan
        imagecopy($dest, $image, 0, 0, 626, 224, 38, 24); // other clan

        $response = new Response();

        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', 'image/png');
        $response->headers->set('Content-Disposition', 'inline; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

        $response->sendHeaders();
        //$response->setContent(readfile($filename));
        $response->setContent(imagepng($dest, NULL, 0, PNG_NO_FILTER));
        return;
    }

}
