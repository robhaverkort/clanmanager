<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Warevent
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClanmanagerBundle\Entity\WareventRepository")
 */
class Warevent {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Warplayer", inversedBy="attacks")
     */
    protected $attacker;

    /**
     * @ORM\ManyToOne(targetEntity="Warplayer", inversedBy="defends")
     */
    protected $defender;

    /**
     * @var integer
     *
     * @ORM\Column(name="stars", type="integer")
     */
    private $stars;

    /**
     * @var integer
     *
     * @ORM\Column(name="percent", type="integer")
     */
    private $percent;

    /**
     * @var time
     *
     * @ORM\Column(name="time", type="time")
     */
    private $time;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set stars
     *
     * @param integer $stars
     * @return Warevent
     */
    public function setStars($stars) {
        $this->stars = $stars;

        return $this;
    }

    /**
     * Get stars
     *
     * @return integer 
     */
    public function getStars() {
        return $this->stars;
    }

    /**
     * Set percent
     *
     * @param integer $percent
     * @return Warevent
     */
    public function setPercent($percent) {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return integer 
     */
    public function getPercent() {
        return $this->percent;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return Warevent
     */
    public function setTime($time) {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * Set attacker
     *
     * @param \ClanmanagerBundle\Entity\Warplayer $attacker
     * @return Warevent
     */
    public function setAttacker(\ClanmanagerBundle\Entity\Warplayer $attacker = null) {
        $this->attacker = $attacker;

        return $this;
    }

    /**
     * Get attacker
     *
     * @return \ClanmanagerBundle\Entity\Warplayer 
     */
    public function getAttacker() {
        return $this->attacker;
    }

    /**
     * Set defender
     *
     * @param \ClanmanagerBundle\Entity\Warplayer $defender
     * @return Warevent
     */
    public function setDefender(\ClanmanagerBundle\Entity\Warplayer $defender = null) {
        $this->defender = $defender;

        return $this;
    }

    /**
     * Get defender
     *
     * @return \ClanmanagerBundle\Entity\Warplayer 
     */
    public function getDefender() {
        return $this->defender;
    }

    public function getWar() {
        return $this->getAttacker()->getWarclan()->getWar();
    }

}
