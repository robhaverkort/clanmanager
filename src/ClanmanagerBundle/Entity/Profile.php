<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Profile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClanmanagerBundle\Entity\ProfileRepository")
 */
class Profile {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookname", type="string", length=32, nullable=true)
     */
    private $facebookname;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookprofile", type="string", length=64, nullable=true)
     */
    private $facebookprofile;

    /**
     * @ORM\OneToMany(targetEntity="Player", mappedBy="profile")
     */
    protected $players;

    public function __construct() {
        $this->players = new ArrayCollection();
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
     * Set user
     *
     * @param \ClanmanagerBundle\Entity\User $user
     * @return Profile
     */
    public function setUser(\ClanmanagerBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ClanmanagerBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set facebookname
     *
     * @param string $facebookname
     * @return Profile
     */
    public function setFacebookname($facebookname) {
        $this->facebookname = $facebookname;

        return $this;
    }

    /**
     * Get facebookname
     *
     * @return string 
     */
    public function getFacebookname() {
        return $this->facebookname;
    }

    /**
     * Set facebookprofile
     *
     * @param string $facebookprofile
     * @return Profile
     */
    public function setFacebookprofile($facebookprofile) {
        $this->facebookprofile = $facebookprofile;

        return $this;
    }

    /**
     * Get facebookprofile
     *
     * @return string 
     */
    public function getFacebookprofile() {
        return $this->facebookprofile;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Profile
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
     * Add players
     *
     * @param \ClanmanagerBundle\Entity\Player $players
     * @return Profile
     */
    public function addPlayer(\ClanmanagerBundle\Entity\Player $players)
    {
        $this->players[] = $players;

        return $this;
    }

    /**
     * Remove players
     *
     * @param \ClanmanagerBundle\Entity\Player $players
     */
    public function removePlayer(\ClanmanagerBundle\Entity\Player $players)
    {
        $this->players->removeElement($players);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }
}
