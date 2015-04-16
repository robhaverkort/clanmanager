<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * War
 *
 * @ORM\Table(name="War")
 * @ORM\Entity(repositoryClass="ClanmanagerBundle\Entity\WarRepository")
 */
class War {

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
     * @var integer
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @ORM\ManyToMany(targetEntity="Clan", inversedBy="wars")
     * */
    private $clans;

    public function __construct() {
        $this->clans = new ArrayCollection();
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
     * Add clans
     *
     * @param \ClanmanagerBundle\Entity\Clan $clans
     * @return War
     */
    public function addClan(\ClanmanagerBundle\Entity\Clan $clans) {
        $this->clans[] = $clans;

        return $this;
    }

    /**
     * Remove clans
     *
     * @param \ClanmanagerBundle\Entity\Clan $clans
     */
    public function removeClan(\ClanmanagerBundle\Entity\Clan $clans) {
        $this->clans->removeElement($clans);
    }

    /**
     * Get clans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClans() {
        return $this->clans;
    }


    /**
     * Set start
     *
     * @param \DateTime $start
     * @return War
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
     * Set size
     *
     * @param integer $size
     * @return War
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }
}
