<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Warclan
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClanmanagerBundle\Entity\WarclanRepository")
 */
class Warclan {

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
     * @ORM\Column(name="wins", type="integer")
     */
    private $wins;

    /**
     * @ORM\ManyToOne(targetEntity="Clan", inversedBy="warclans")
     * @ORM\JoinColumn(name="clan_id", referencedColumnName="id")
     */
    protected $clan;

    /**
     * @ORM\ManyToOne(targetEntity="War", inversedBy="warclans")
     * @ORM\JoinColumn(name="war_id", referencedColumnName="id")
     */
    protected $war;

    /**
     * @ORM\OneToMany(targetEntity="Warplayer", mappedBy="warclan")
     */
    protected $warplayers;

    /**
     * Constructor
     */
    public function __construct() {
        $this->warplayers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set clan
     *
     * @param \ClanmanagerBundle\Entity\Clan $clan
     * @return Warclan
     */
    public function setClan(\ClanmanagerBundle\Entity\Clan $clan = null) {
        $this->clan = $clan;

        return $this;
    }

    /**
     * Get clan
     *
     * @return \ClanmanagerBundle\Entity\Clan 
     */
    public function getClan() {
        return $this->clan;
    }

    /**
     * Set war
     *
     * @param \ClanmanagerBundle\Entity\War $war
     * @return Warclan
     */
    public function setWar(\ClanmanagerBundle\Entity\War $war = null) {
        $this->war = $war;

        return $this;
    }

    /**
     * Get war
     *
     * @return \ClanmanagerBundle\Entity\War 
     */
    public function getWar() {
        return $this->war;
    }

    /**
     * Add warplayers
     *
     * @param \ClanmanagerBundle\Entity\Warplayer $warplayers
     * @return Warclan
     */
    public function addWarplayer(\ClanmanagerBundle\Entity\Warplayer $warplayers) {
        $this->warplayers[] = $warplayers;

        return $this;
    }

    /**
     * Remove warplayers
     *
     * @param \ClanmanagerBundle\Entity\Warplayer $warplayers
     */
    public function removeWarplayer(\ClanmanagerBundle\Entity\Warplayer $warplayers) {
        $this->warplayers->removeElement($warplayers);
    }

    /**
     * Get warplayers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWarplayers() {
        return $this->warplayers;
    }

    /**
     * Set wins
     *
     * @param integer $wins
     * @return Warclan
     */
    public function setWins($wins) {
        $this->wins = $wins;

        return $this;
    }

    /**
     * Get wins
     *
     * @return integer 
     */
    public function getWins() {
        return $this->wins;
    }

}
