<?php
// src/Collective/GovtBundle/Entity/Location.php
namespace Collective\GovtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
    
/**
 * @ORM\Entity
 * @ORM\Table(name="location")
 */
class Location
{
    /**
     * @ORM\OneToMany(targetEntity="Link", mappedBy="location")
     */
    protected $links;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    protected $lat;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    protected $lon;
    
    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    /**
     * To string
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->name . ' ' . $this->getLon() . ',' . $this->getLat();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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

    /**
     * Set lat
     *
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param float $lon
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
    }

    /**
     * Get lon
     *
     * @return float 
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Add links
     *
     * @param Collective\GovtBundle\Entity\Link $links
     */
    public function addLink(\Collective\GovtBundle\Entity\Link $links)
    {
        $this->links[] = $links;
    }

    /**
     * Get links
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLinks()
    {
        return $this->links;
    }
}