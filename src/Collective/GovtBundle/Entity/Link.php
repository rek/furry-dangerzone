<?php
// src/Collective/GovtBundle/Entity/Link.php
namespace Collective\GovtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="link")
 */
class Link
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $link;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $type;    

    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="link")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;    

    /**
     * To string
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->title . ': ' . $this->link;
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
     * Set link
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set location
     *
     * @param Collective\GovtBundle\Entity\Location $location
     */
    public function setLocation(\Collective\GovtBundle\Entity\Location $location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return Collective\GovtBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}