<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @var integer
     *
     * @ORM\Column(name="th", type="integer")
     */
    private $th;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="warplayers")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;

    /**
     * @ORM\ManyToOne(targetEntity="War", inversedBy="warplayers")
     * @ORM\JoinColumn(name="war_id", referencedColumnName="id")
     */
    protected $war;

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
     * Set war
     *
     * @param \ClanmanagerBundle\Entity\War $war
     * @return Warplayer
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
     * Set rank
     *
     * @param integer $rank
     * @return Warplayer
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set th
     *
     * @param integer $th
     * @return Warplayer
     */
    public function setTh($th)
    {
        $this->th = $th;

        return $this;
    }

    /**
     * Get th
     *
     * @return integer 
     */
    public function getTh()
    {
        return $this->th;
    }
}
