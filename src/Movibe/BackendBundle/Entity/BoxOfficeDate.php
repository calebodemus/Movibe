<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoxOfficeDate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\BoxOfficeDateRepository")
 */
class BoxOfficeDate
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="dateBox", type="string")
     */
    private $dateBox;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\BoxOffice", mappedBy="dateBox",cascade={"persist","remove"})
     */
    private $boxOffices;

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDateBox()
    {
        $date = new \Datetime($this->dateBox);
        return $date;
    }

    public function getDateBoxString()
    {
        return $this->dateBox;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->boxOffices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set dateBox
     *
     * @param \DateTime $dateBox
     * @return BoxOfficeDate
     */
    public function setDateBox(\DateTime $dateBox)
    {
        $this->dateBox = $dateBox->format('Y/m/d');

        $day   = $dateBox->format('d'); // Format the current date, take the current day (01 to 31)
        $month = $dateBox->format('m'); // Same with the month
        $year  = $dateBox->format('Y'); // Same with the year

        $dateBox = $year.'/'.$month.'/'.$day; // Return a string and not an object

        return $dateBox;
    }

    /**
     * Add boxOffices
     *
     * @param \Movibe\BackendBundle\Entity\BoxOffice $boxOffices
     * @return BoxOfficeDate
     */
    public function addBoxOffice(\Movibe\BackendBundle\Entity\BoxOffice $boxOffices)
    {
        $this->boxOffices[] = $boxOffices;
        $boxOffices->setDateBox($this);

        return $this;
    }

    /**
     * Remove boxOffices
     *
     * @param \Movibe\BackendBundle\Entity\BoxOffice $boxOffices
     */
    public function removeBoxOffice(\Movibe\BackendBundle\Entity\BoxOffice $boxOffices)
    {
        $this->boxOffices->removeElement($boxOffices);
    }

    /**
     * Get boxOffices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBoxOffices()
    {
        return $this->boxOffices;
    }

    public function setBoxOffices()
    {
        $this->boxOffices = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
