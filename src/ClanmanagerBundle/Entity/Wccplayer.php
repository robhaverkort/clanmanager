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
    public function addWccplayer(\ClanmanagerBundle\Entity\Wccstats $wccplayer)
    {
        $this->wccplayer[] = $wccplayer;

        return $this;
    }

    /**
     * Remove wccplayer
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccplayer
     */
    public function removeWccplayer(\ClanmanagerBundle\Entity\Wccstats $wccplayer)
    {
        $this->wccplayer->removeElement($wccplayer);
    }

    /**
     * Get wccplayer
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWccplayer()
    {
        return $this->wccplayer;
    }

    /**
     * Add wccstats
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccstats
     * @return Wccplayer
     */
    public function addWccstat(\ClanmanagerBundle\Entity\Wccstats $wccstats)
    {
        $this->wccstats[] = $wccstats;

        return $this;
    }

    /**
     * Remove wccstats
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccstats
     */
    public function removeWccstat(\ClanmanagerBundle\Entity\Wccstats $wccstats)
    {
        $this->wccstats->removeElement($wccstats);
    }

    /**
     * Get wccstats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWccstats()
    {
        return $this->wccstats;
    }
    
    public function __toString() {
        return $this->profile;
    }
}
