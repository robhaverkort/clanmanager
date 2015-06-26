<?php

namespace ClanmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ClanmanagerBundle\Entity\War;
use ClanmanagerBundle\Entity\Clan;
use ClanmanagerBundle\Entity\Player;
use ClanmanagerBundle\Entity\Membership;
use ClanmanagerBundle\Entity\Warclan;
use ClanmanagerBundle\Entity\Warplayer;

class WarController extends Controller {

    /**
     * @Route("/war", name="war")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ClanmanagerBundle:War');
        //$wars = $repository->findAll();
        $wars = $repository->findBy(array(), array('start' => 'DESC'));
        //$wars = $repository->findByPlayerId($this->getUser()->getProfile()->getPlayers()[0]->getId());
        return $this->render('ClanmanagerBundle:War:index.html.twig', array('wars' => $wars));
    }

    /**
     * @Route("/war/new", name="war_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request) {

        $war = new War();

        $form = $this->createFormBuilder($war)
                ->setAction($this->generateUrl('war_new'))
                ->add('start', 'datetime', array('minutes' => array(0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55), 'data' => new \DateTime()))
                ->add('size', 'choice', array('data' => 30, 'choices' => array(10 => '10v10', 15 => '15v15', 20 => '20v20', 25 => '25v25', 30 => '30v30', 35 => '35v35', 40 => '40v40', 45 => '45v45', 50 => '50v50')))
                ->add('clantag', 'text', array('mapped' => false, 'data' => '#'))
                ->add('clanname', 'text', array('mapped' => false))
                ->add('clanwins', 'text', array('mapped' => false))
                ->add('myclanwins', 'text', array('mapped' => false))
                ->add('save', 'submit', array('label' => 'Add War'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            //$war->setStart($form['start']->getData());
            //$war->setSize($form['size']->getData());
            $em->persist($war);

            // MY CLAN
            $mclan = $this->getDoctrine()->getManager()->getRepository('ClanmanagerBundle:Clan')->find(1);

            $mwarclan = new Warclan();
            $mwarclan->setWar($war);
            $mwarclan->setClan($mclan);
            $mwarclan->setWins($form['myclanwins']->getData());
            $em->persist($mwarclan);

            for ($rank = 1; $rank <= $war->getSize(); $rank++) {
                $warplayer = new Warplayer();
                $warplayer->setRank($rank);
                $warplayer->setWarclan($mwarclan);
                $em->persist($warplayer);
            }

            // ENEMY CLAN
            $eclan = new Clan();
            $eclan->setName($form['clanname']->getData());
            $eclan->setTag($form['clantag']->getData());
            $em->persist($eclan);

            $ewarclan = new Warclan();
            $ewarclan->setWar($war);
            $ewarclan->setClan($eclan);
            $ewarclan->setWins($form['clanwins']->getData());
            $em->persist($ewarclan);

            for ($rank = 1; $rank <= $war->getSize(); $rank++) {
                $player = new Player();
                $player->setName("---");
                $em->persist($player);

                $membership = new Membership();
                $membership->setPlayer($player);
                $membership->setClan($ewarclan->getClan());
                $em->persist($membership);

                $warplayer = new Warplayer();
                $warplayer->setRank($rank);
                $warplayer->setWarclan($ewarclan);
                $warplayer->setPlayer($player);
                $em->persist($warplayer);
            }

            $em->flush();

            $this->addFlash('notice', 'Your changes were saved!');
            return $this->redirectToRoute('war');
        }
        return $this->render('ClanmanagerBundle:War:new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/war/{war_id}", name="war_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($war_id) {
        $em = $this->getDoctrine();
        $war = $em->getRepository('ClanmanagerBundle:War')->find($war_id);
        $warclans = $em->getRepository('ClanmanagerBundle:Warclan')->findByWar($war);
        $warevents = $em->getRepository('ClanmanagerBundle:Warevent')->findByWarId($war->getId());

        // graph attacks per stars
        $results = array();
        for ($n = 0; $n < 4; $n++) {
            $results[0][$n] = 0;
            $results[1][$n] = 0;
        }
        foreach ($warevents as $warevent) {
            if ($warevent->getAttacker()->getWarclan() == $warclans[0]) {
                $results[0][$warevent->getStars()]+=1;
            } else {
                $results[1][$warevent->getStars()]+=1;
            }
        }

        return $this->render('ClanmanagerBundle:War:view.html.twig', array('war' => $war, 'warevents' => $warevents, 'results' => $results));
    }

}
