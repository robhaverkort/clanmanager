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
     * @var integer
     *
     * @ORM\Column(name="stars", type="integer", nullable=true)
     */
    private $stars;

     /**
     * @var float
     *
     * @ORM\Column(name="percent", type="float", nullable=true)
     */
    private $percent;

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

    /**
     * Get nr of Attacks
     * 
     * returns the number of attacks made by this warclan.
     *
     * @return integer 
     */
    public function getNrattacks() {
        $nrattacks = 0;
        foreach ($this->getWarplayers() as $warplayer) {
            $nrattacks += sizeof($warplayer->getAttacks());
        }
        return $nrattacks;
    }

    /**
     * Get Stars
     * 
     * returns the number of stars suffered by this warclan.
     *
     * @return integer 
     */
    public function getStars() {
        return $this->stars;
    }

    public function getTimestars() {
        $totalstars = array(0);
        for ($hour = 0; $hour < 24; $hour++) {
            $nrstars = 0;
            foreach ($this->getWarplayers() as $warplayer) {
                $stars = array(0);
                foreach ($warplayer->getDefends() as $warevent) {
                    if (date_format($warevent->getTime(), "H") >= $hour) {
                        $stars[] = $warevent->getStars();
                    }
                }
                $nrstars += max($stars);
            }
            $totalstars[$hour] = $nrstars;
        }
        return $totalstars;
    }

    public function getNrTH($th) {
        $nr = 0;
        foreach ($this->getWarplayers() as $warplayer) {
            if ($warplayer->getTh() == $th)
                $nr++;
        }
        return $nr ? $nr : "-";
    }

    public function getTimeattacks() {
        $totalattacks = array(0);
        for ($hour = 0; $hour < 24; $hour++) {
            $nrattacks = 0;
            foreach ($this->getWarplayers() as $warplayer) {
                $attacks = 0;
                foreach ($warplayer->getDefends() as $warevent) {
                    if (date_format($warevent->getTime(), "H") >= $hour) {
                        $attacks += 1;
                    }
                }
                $nrattacks += $attacks;
            }
            $totalattacks[$hour] = $nrattacks;
        }
        return $totalattacks;
    }

    /**
     * Set stars
     *
     * @param integer $stars
     * @return Warclan
     */
    public function setStars($stars) {
        $this->stars = $stars;

        return $this;
    }


    /**
     * Set percent
     *
     * @param float $percent
     * @return Warclan
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return float 
     */
    public function getPercent()
    {
        return $this->percent;
    }
}
