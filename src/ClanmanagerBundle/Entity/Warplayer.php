<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Warplayer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClanmanagerBundle\Entity\WarplayerRepository")
 */
class Warplayer {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $rank;

    /**
     * @var integer
     *
     * @ORM\Column(name="th", type="integer", nullable=true)
     */
    private $th;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="warplayers")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;

    /**
     * @ORM\ManyToOne(targetEntity="Warclan", inversedBy="warplayers")
     * @ORM\JoinColumn(name="warclan_id", referencedColumnName="id")
     */
    protected $warclan;

    /**
     * @ORM\OneToMany(targetEntity="Warevent", mappedBy="attacker")
     */
    protected $attacks;

    /**
     * @ORM\OneToMany(targetEntity="Warevent", mappedBy="defender")
     */
    protected $defends;

    /**
     * Constructor
     */
    public function __construct() {
        $this->attacks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->defends = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->warplayers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set player
     *
     * @param \ClanmanagerBundle\Entity\Player $player
     * @return Warplayer
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
     * Set rank
     *
     * @param integer $rank
     * @return Warplayer
     */
    public function setRank($rank) {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank() {
        return $this->rank;
    }

    /**
     * Set th
     *
     * @param integer $th
     * @return Warplayer
     */
    public function setTh($th) {
        $this->th = $th;

        return $this;
    }

    /**
     * Get th
     *
     * @return integer 
     */
    public function getTh() {
        return $this->th;
    }

    /**
     * Set warclan
     *
     * @param \ClanmanagerBundle\Entity\Warclan $warclan
     * @return Warplayer
     */
    public function setWarclan(\ClanmanagerBundle\Entity\Warclan $warclan = null) {
        $this->warclan = $warclan;

        return $this;
    }

    /**
     * Get warclan
     *
     * @return \ClanmanagerBundle\Entity\Warclan 
     */
    public function getWarclan() {
        return $this->warclan;
    }

    /**
     * Add attacks
     *
     * @param \ClanmanagerBundle\Entity\Warevent $attacks
     * @return Warplayer
     */
    public function addAttack(\ClanmanagerBundle\Entity\Warevent $attacks) {
        $this->attacks[] = $attacks;

        return $this;
    }

    /**
     * Remove attacks
     *
     * @param \ClanmanagerBundle\Entity\Warevent $attacks
     */
    public function removeAttack(\ClanmanagerBundle\Entity\Warevent $attacks) {
        $this->attacks->removeElement($attacks);
    }

    /**
     * Get attacks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttacks() {
        return $this->attacks;
    }

    /**
     * Add defends
     *
     * @param \ClanmanagerBundle\Entity\Warevent $defends
     * @return Warplayer
     */
    public function addDefend(\ClanmanagerBundle\Entity\Warevent $defends) {
        $this->defends[] = $defends;

        return $this;
    }

    /**
     * Remove defends
     *
     * @param \ClanmanagerBundle\Entity\Warevent $defends
     */
    public function removeDefend(\ClanmanagerBundle\Entity\Warevent $defends) {
        $this->defends->removeElement($defends);
    }

    /**
     * Get defends
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDefends() {
        return $this->defends;
    }

    public function __toString() {
        return $this->getRank() . ". " . $this->getPlayer()->getName(); // . " - " . $this->getId();
    }

    /**
     * Get Stars
     * 
     * returns the number of stars suffered by this warplayer.
     *
     * @return integer 
     */
    public function getStars($time = NULL) {
        $nrstars = 0;
        $stars = array(0);
        foreach ($this->getDefends() as $warevent) {
            if ($warevent->getTime() > $time ) //new \DateTime("23:10"))
                $stars[] = $warevent->getStars();
        }
        $nrstars += max($stars);
        return $nrstars;
    }

}
