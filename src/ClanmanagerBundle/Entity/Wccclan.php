<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Wccclan
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Wccclan {

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
     * @ORM\OneToOne(targetEntity="Clan", inversedBy="wccclan")
     * */
    private $clan;

    /**
     * @ORM\OneToMany(targetEntity="Wccstats", mappedBy="wccclan")
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
     * @return Wccclan
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
     * @return Wccclan
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
     * Set clan
     *
     * @param \ClanmanagerBundle\Entity\Clan $clan
     * @return Wccclan
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
     * Add wccclan
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccclan
     * @return Wccclan
     */
    public function addWccclan(\ClanmanagerBundle\Entity\Wccstats $wccclan)
    {
        $this->wccclan[] = $wccclan;

        return $this;
    }

    /**
     * Remove wccclan
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccclan
     */
    public function removeWccclan(\ClanmanagerBundle\Entity\Wccstats $wccclan)
    {
        $this->wccclan->removeElement($wccclan);
    }

    /**
     * Get wccclan
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWccclan()
    {
        return $this->wccclan;
    }

    /**
     * Add wccstats
     *
     * @param \ClanmanagerBundle\Entity\Wccstats $wccstats
     * @return Wccclan
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
}
