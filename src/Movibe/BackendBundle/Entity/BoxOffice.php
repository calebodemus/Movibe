<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoxOffice
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\BoxOfficeRepository")
 */
class BoxOffice
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
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\BoxOfficeDate", inversedBy=" $boxOffices")
     * @ORM\JoinColumn(nullable=false, name="dateBox", referencedColumnName="dateBox")
     */
    private $dateBox;

    /**
     * @var integer
     *
     * @ORM\Column(name="entree", type="integer")
     */
    private $entree;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Film", inversedBy=" $boxOffices")
     */
    private $film;


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
     * Set entree
     *
     * @param integer $entree
     * @return BoxOffice
     */
    public function setEntree($entree)
    {
        $this->entree = $entree;

        return $this;
    }

    /**
     * Get entree
     *
     * @return integer 
     */
    public function getEntree()
    {
        return $this->entree;
    }

    /**
     * Set film
     *
     * @param \Movibe\BackendBundle\Entity\Film $film
     * @return BoxOffice
     */
    public function setFilm(\Movibe\BackendBundle\Entity\Film $film)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return \Movibe\BackendBundle\Entity\Film 
     */
    public function getFilm()
    {
        return $this->film;
    }

    /**
     * Set dateBox
     *
     * @param \Movibe\BackendBundle\Entity\BoxOfficeDate $dateBox
     * @return BoxOffice
     */
    public function setDateBox(\Movibe\BackendBundle\Entity\BoxOfficeDate $dateBox)
    {
        $this->dateBox = $dateBox;

        return $this;
    }

    /**
     * Get dateBox
     *
     * @return \Movibe\BackendBundle\Entity\BoxOfficeDate 
     */
    public function getDateBox()
    {
        return $this->dateBox;
    }

}
