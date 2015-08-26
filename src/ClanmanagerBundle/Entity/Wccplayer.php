<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wccplayer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Wccplayer {

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
     * @return Wccplayer
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return string 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Wccplayer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
