<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wccstats
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Wccstats {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", name="posted_at",nullable=true)
     */
    private $postedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Wccplayer", inversedBy="wccstats")
     */
    protected $wccplayer;

    /**
     * @ORM\ManyToOne(targetEntity="Wccclan", inversedBy="wccstats")
     */
    protected $wccclan;

    /**
     * @ORM\Column(type="text")
     */
    private $json;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set postedAt
     *
     * @param \timestamp $postedAt
     * @return Wccstats
     */
    public function setPostedAt(\timestamp $postedAt) {
        $this->postedAt = $postedAt;

        return $this;
    }

    /**
     * Get postedAt
     *
     * @return \timestamp 
     */
    public function getPostedAt() {
        return $this->postedAt;
    }

    /**
     * Set wccplayer
     *
     * @param \ClanmanagerBundle\Entity\Wccplayer $wccplayer
     * @return Wccstats
     */
    public function setWccplayer(\ClanmanagerBundle\Entity\Wccplayer $wccplayer = null) {
        $this->wccplayer = $wccplayer;

        return $this;
    }

    /**
     * Get wccplayer
     *
     * @return \ClanmanagerBundle\Entity\Wccplayer 
     */
    public function getWccplayer() {
        return $this->wccplayer;
    }

    /**
     * Set wccclan
     *
     * @param \ClanmanagerBundle\Entity\Wccclan $wccclan
     * @return Wccstats
     */
    public function setWccclan(\ClanmanagerBundle\Entity\Wccclan $wccclan = null) {
        $this->wccclan = $wccclan;

        return $this;
    }

    /**
     * Get wccclan
     *
     * @return \ClanmanagerBundle\Entity\Wccclan 
     */
    public function getWccclan() {
        return $this->wccclan;
    }

    /**
     * Set json
     *
     * @param string $json
     * @return Wccstats
     */
    public function setJson($json) {
        $this->json = $json;

        return $this;
    }

    /**
     * Get json
     *
     * @return string 
     */
    public function getJson() {
        return $this->json;
    }

}
