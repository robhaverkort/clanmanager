<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Clan
 *
 * @ORM\Table(name="Clan")
 * @ORM\Entity(repositoryClass="ClanmanagerBundle\Entity\ClanRepository")
 */
class Clan {

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
     * @ORM\Column(name="tag", type="string", length=9, unique=true)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Membership", mappedBy="clan")
     */
    protected $memberships;

    public function __construct() {
        $this->memberships = new ArrayCollection();
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
     * Set tag
     *
     * @param string $tag
     * @return Clan
     */
    public function setTag($tag) {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag() {
        return $this->tag;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Clan
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
     * Add memberships
     *
     * @param \ClanmanagerBundle\Entity\Membership $memberships
     * @return Clan
     */
    public function addMembership(\ClanmanagerBundle\Entity\Membership $memberships)
    {
        $this->memberships[] = $memberships;

        return $this;
    }

    /**
     * Remove memberships
     *
     * @param \ClanmanagerBundle\Entity\Membership $memberships
     */
    public function removeMembership(\ClanmanagerBundle\Entity\Membership $memberships)
    {
        $this->memberships->removeElement($memberships);
    }

    /**
     * Get memberships
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMemberships()
    {
        return $this->memberships;
    }
}
