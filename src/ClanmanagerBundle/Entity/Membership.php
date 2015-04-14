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
    public function setPlayer(\ClanmanagerBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \ClanmanagerBundle\Entity\Player 
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set clan
     *
     * @param \ClanmanagerBundle\Entity\Clan $clan
     * @return Membership
     */
    public function setClan(\ClanmanagerBundle\Entity\Clan $clan = null)
    {
        $this->clan = $clan;

        return $this;
    }

    /**
     * Get clan
     *
     * @return \ClanmanagerBundle\Entity\Clan 
     */
    public function getClan()
    {
        return $this->clan;
    }
}
