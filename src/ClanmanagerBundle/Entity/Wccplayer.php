<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Wccplayer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Wccplayer {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="profile", type="string", length=9, unique=true)
     */
    private $profile;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="Player", inversedBy="wccplayer")
     * */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="Wccstats", mappedBy="wccplayer")
     */
    protected $wccstats;

    public function __construct() {
        $this->wccstats = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set profile
     *
     * @param string $profile
     * @return Wccplayer
     */
    public function setProfile($profile) {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return string 
     */
    public function getProfile() {
        return $this->profile;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Wccplayer
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set player
     *
     * @param \ClanmanagerBundle\Entity\Player $player
     * @return Wccplayer
     */
    public function setPlayer(\ClanmanagerBundle\Entity\Player $player = null) {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \ClanmanagerBundle\Entity\Player 
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     * Add wccplayer
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccplayer
     * @return Wccplayer
     */
    public function addWccplayer(\ClanmanagerBundle\Entity\Wccstats $wccplayer) {
        $this->wccplayer[] = $wccplayer;

        return $this;
    }

    /**
     * Remove wccplayer
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccplayer
     */
    public function removeWccplayer(\ClanmanagerBundle\Entity\Wccstats $wccplayer) {
        $this->wccplayer->removeElement($wccplayer);
    }

    /**
     * Get wccplayer
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWccplayer() {
        return $this->wccplayer;
    }

    /**
     * Add wccstats
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccstats
     * @return Wccplayer
     */
    public function addWccstat(\ClanmanagerBundle\Entity\Wccstats $wccstats) {
        $this->wccstats[] = $wccstats;

        return $this;
    }

    /**
     * Remove wccstats
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccstats
     */
    public function removeWccstat(\ClanmanagerBundle\Entity\Wccstats $wccstats) {
        $this->wccstats->removeElement($wccstats);
    }

    /**
     * Get wccstats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWccstats() {
        return $this->wccstats;
    }

    public function __toString() {
        return $this->profile;
    }

    public function getOffenseweight($timestamp = NULL) {

        $values['barbarianking'] = array(0, 15, 30, 45, 60, 76, 92, 108, 124, 140, 157, 174, 191, 208, 225, 243, 261, 279, 297, 315, 335, 353, 372, 391, 410, 430, 450, 470, 490, 510, 531, 552, 573, 594, 615, 637, 659, 681, 703, 725, 747);
        $values['archerqueen'] = array(0, 26, 52, 78, 104, 131, 158, 185, 212, 239, 267, 295, 323, 351, 379, 408, 437, 466, 495, 524, 554, 584, 614, 644, 674, 705, 736, 767, 798, 829, 861, 893, 925, 957, 989, 1022, 1055, 1088, 1121, 1154, 1187);
        $values['lightningspell'] = array(0, 100, 200, 300, 400, 500, 600);
        $values['healingspell'] = array(0, 200, 400, 600, 800, 1000, 1200);
        $values['ragespell'] = array(0, 100, 200, 300, 400, 500);
        $values['jumpspell'] = array(0, 100, 200, 300);
        $values['freezespell'] = array(0, 1000, 2000, 3000, 4000, 5000);
        $values['barbarian'] = array(0, 100, 200, 300, 400, 500, 600, 700);
        $values['archer'] = array(0, 150, 300, 450, 600, 750, 900, 1050);
        $values['giant'] = array(0, 120, 240, 360, 480, 600, 720, 840);
        $values['goblin'] = array(0, 50, 100, 150, 200, 250, 300);
        $values['wallbreaker'] = array(0, 100, 200, 300, 400, 500, 600);
        $values['balloon'] = array(0, 120, 240, 360, 480, 600, 720);
        $values['wizard'] = array(0, 150, 300, 450, 600, 750, 900);
        $values['healer'] = array(0, 180, 360, 540, 720);
        $values['dragon'] = array(0, 150, 300, 450, 600);
        $values['pekka'] = array(0, 120, 240, 360, 480, 600);
        $values['minion'] = array(0, 120, 240, 360, 480, 600, 720);
        $values['hogrider'] = array(0, 120, 240, 360, 480, 600);
        $values['valkyrie'] = array(0, 100, 200, 300, 400);
        $values['golem'] = array(0, 120, 240, 360, 480, 600);
        $values['witch'] = array(0, 900, 2100);
        $values['lavahound'] = array(0, 120, 240, 360);

        $wccstats = $this->getWccstats()->toArray();
        $offenseweight = 0;

        if (sizeof($wccstats)) {

            $wccstat = end($wccstats);

            if ($timestamp) {
                $wccstat = reset($wccstats);
                if ($wccstat->getCreatedat() > $timestamp)
                    return 0;

                for ($n = sizeof($wccstats) - 1; $n >= 0; $n--) {
                    if ($wccstats[$n]->getCreatedat() <= $timestamp) {
                        $wccstat = $wccstats[$n];
                        break;
                    }
                }
            }
//            $wccstat = end($wccstats);
//            if ($timestamp) {
//                while ($wccstat->getCreatedat() >= $timestamp && prev($wccstats)) {
//                    $wccstat = current($wccstats);
//                }
//            }


            $wccstat = json_decode($wccstat->getJson());
            foreach (array_keys($values) as $key) {
                $offenseweight += $wccstat->{'troops'}->{$key} ? $values[$key][$wccstat->{'troops'}->{$key}] : 0;
            }
        }

        return $offenseweight;
    }

    public function getDefenseweight($timestamp = NULL) {

        //$values['walls'] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
        $values['cannon'] = array(0, 100, 199, 297, 394, 490, 585, 679, 772, 864, 955, 1045, 1134, 1222);
        $values['archertower'] = array(0, 100, 199, 297, 394, 490, 585, 679, 772, 864, 955, 1045, 1134, 1222);
        $values['wizardtower'] = array(0, 500, 970, 1410, 1820, 2200, 2550, 2870, 3160);
        $values['airdefense'] = array(0, 40, 80, 120, 160, 200, 240, 280, 320);
        $values['mortar'] = array(0, 500, 990, 1470, 1940, 2400, 2850, 3290, 3720);
        $values['tesla'] = array(0, 100, 200, 300, 400, 500, 600, 700, 800);
        $values['xbow'] = array(0, 400, 800, 1200, 1600);
        $values['inferno'] = array(0, 1000, 2000, 3000);
        $values['airsweeper'] = array(0, 10, 20, 30, 40, 50, 60);
        $values['smallbomb'] = array(0, 100, 200, 300, 400, 500, 600);
        $values['giantbomb'] = array(0, 100, 200, 300, 400);
        $values['seekingairmine'] = array(0, 20, 40, 60);
        $values['airbomb'] = array(0, 50, 100, 150, 200);
        $values['skeletontrap'] = array(0, 50, 50, 50);
        $values['wall'] = array(0, 4.3, 8.4, 12.6, 16.8, 21.0, 25.2, 29.4, 33.6, 37.8, 42.0, 46.2);
        $values['springtrap'] = array(0, 20.0);

        $wccstats = $this->getWccstats()->toArray();
        $defenseweight = 0;

        if (sizeof($wccstats)) {

            $wccstat = end($wccstats);

            if ($timestamp) {
                $wccstat = reset($wccstats);
                if ($wccstat->getCreatedat() > $timestamp)
                    return 0;

                for ($n = sizeof($wccstats) - 1; $n >= 0; $n--) {
                    if ($wccstats[$n]->getCreatedat() <= $timestamp) {
                        $wccstat = $wccstats[$n];
                        break;
                    }
                }
            }

            $wccstat = json_decode($wccstat->getJson(), true);
            if (isset($wccstat['village'])) {
                foreach ($wccstat['village'] as $key=>$bld) {
                    //var_dump($wccstat['village']);
                    //var_dump($key);var_dump($bld);
                    foreach ($bld as $lev => $val) {
                        //var_dump($key);var_dump(array_keys($values));var_dump(in_array($key, array_keys($values)));exit;
                        //var_dump($lev);var_dump($val);exit;
                        if (in_array($key, array_keys($values))) {
                            $defenseweight += $val * $values[$key][$lev];
                        }
                    }
                }
            }
        }

        return $defenseweight;
    }

}
