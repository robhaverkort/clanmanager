<?php

namespace ClanmanagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wccstats
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Wccstats
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
