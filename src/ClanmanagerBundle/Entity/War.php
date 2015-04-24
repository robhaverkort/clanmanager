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
     * @ORM\OneToMany(targetEntity="Warclan", mappedBy="war")
     */
    protected $warclans;

    public function __construct() {
        $this->warclans = new ArrayCollection();
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
     * Set start
     *
     * @param \DateTime $start
     * @return War
     */
    public function setStart($start) {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return War
     */
    public function setSize($size) {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Add warclans
     *
     * @param \ClanmanagerBundle\Entity\Warclan $warclans
     * @return War
     */
    public function addWarclan(\ClanmanagerBundle\Entity\Warclan $warclans) {
        $this->warclans[] = $warclans;

        return $this;
    }

    /**
     * Remove warclans
     *
     * @param \ClanmanagerBundle\Entity\Warclan $warclans
     */
    public function removeWarclan(\ClanmanagerBundle\Entity\Warclan $warclans) {
        $this->warclans->removeElement($warclans);
    }

    /**
     * Get warclans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWarclans() {
        return $this->warclans;
    }

    public function __toString() {
        return $this->getId() . " " . $this->getWarClans()[0]->getClan()->getName() . " - " . $this->getWarClans()[1]->getClan()->getName();
    }

}
