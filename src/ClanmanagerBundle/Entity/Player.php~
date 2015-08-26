<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Player
 *
 * @ORM\Table(name="Player")
 * @ORM\Entity(repositoryClass="ClanmanagerBundle\Entity\PlayerRepository")
 */
class Player {

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
     * @ORM\Column(name="tag", type="string", length=10, nullable=true)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="th", type="integer", nullable=true)
     */
    private $th;

    /**
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="players")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    protected $profile;

    /**
     * @ORM\OneToMany(targetEntity="Membership", mappedBy="player")
     */
    protected $memberships;

    /**
     * @ORM\OneToMany(targetEntity="Warplayer", mappedBy="player")
     */
    protected $warplayers;

    public function __construct() {
        $this->memberships = new ArrayCollection();
        $this->warplayers = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Player
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
     * Set profile
     *
     * @param \ClanmanagerBundle\Entity\Profile $profile
     * @return Player
     */
    public function setProfile(\ClanmanagerBundle\Entity\Profile $profile = null) {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \ClanmanagerBundle\Entity\Profile 
     */
    public function getProfile() {
        return $this->profile;
    }

    /**
     * Add memberships
     *
     * @param \ClanmanagerBundle\Entity\Membership $memberships
     * @return Player
     */
    public function addMembership(\ClanmanagerBundle\Entity\Membership $memberships) {
        $this->memberships[] = $memberships;

        return $this;
    }

    /**
     * Remove memberships
     *
     * @param \ClanmanagerBundle\Entity\Membership $memberships
     */
    public function removeMembership(\ClanmanagerBundle\Entity\Membership $memberships) {
        $this->memberships->removeElement($memberships);
    }

    /**
     * Get memberships
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMemberships() {
        return $this->memberships;
    }

    /**
     * Set th
     *
     * @param integer $th
     * @return Player
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
     * Add warplayers
     *
     * @param \ClanmanagerBundle\Entity\War $warplayers
     * @return Player
     */
    public function addWarplayer(\ClanmanagerBundle\Entity\War $warplayers)
    {
        $this->warplayers[] = $warplayers;

        return $this;
    }

    /**
     * Remove warplayers
     *
     * @param \ClanmanagerBundle\Entity\War $warplayers
     */
    public function removeWarplayer(\ClanmanagerBundle\Entity\War $warplayers)
    {
        $this->warplayers->removeElement($warplayers);
    }

    /**
     * Get warplayers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWarplayers()
    {
        return $this->warplayers;
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return Player
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
