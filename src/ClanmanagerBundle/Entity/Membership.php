<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Membership
 *
 * @ORM\Table(name="Membership")
 * @ORM\Entity(repositoryClass="ClanmanagerBundle\Entity\MembershipRepository")
 */
class Membership {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var datetime
     *
     * @ORM\Column(name="stop", type="datetime")
     */
    private $stop;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="memberships")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;

    /**
     * @ORM\ManyToOne(targetEntity="Clan", inversedBy="memberships")
     * @ORM\JoinColumn(name="clan_id", referencedColumnName="id")
     */
    protected $clan;

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
     * @return Membership
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
     * Set clan
     *
     * @param \ClanmanagerBundle\Entity\Clan $clan
     * @return Membership
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
     * Set start
     *
     * @param \DateTime $start
     * @return Membership
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set stop
     *
     * @param \DateTime $stop
     * @return Membership
     */
    public function setStop($stop)
    {
        $this->stop = $stop;

        return $this;
    }

    /**
     * Get stop
     *
     * @return \DateTime 
     */
    public function getStop()
    {
        return $this->stop;
    }
}
