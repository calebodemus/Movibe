<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\SeanceRepository")
 */
class Seance
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
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Film", inversedBy="seances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $film;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Cinema", inversedBy="seances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cinema;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\TypeSeance", inversedBy="seances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeSeance;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Horaire", inversedBy="seances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $horaire;

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
     * Set film
     *
     * @param \Movibe\BackendBundle\Entity\Film $film
     * @return Seance
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
     * Set cinema
     *
     * @param \Movibe\BackendBundle\Entity\Cinema $cinema
     * @return Seance
     */
    public function setCinema(\Movibe\BackendBundle\Entity\Cinema $cinema)
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * Get cinema
     *
     * @return \Movibe\BackendBundle\Entity\Cinema 
     */
    public function getCinema()
    {
        return $this->cinema;
    }

    /**
     * Set typeSeance
     *
     * @param \Movibe\BackendBundle\Entity\TypeSeance $typeSeance
     * @return Seance
     */
    public function setTypeSeance(\Movibe\BackendBundle\Entity\TypeSeance $typeSeance)
    {
        $this->typeSeance = $typeSeance;

        return $this;
    }

    /**
     * Get typeSeance
     *
     * @return \Movibe\BackendBundle\Entity\TypeSeance 
     */
    public function getTypeSeance()
    {
        return $this->typeSeance;
    }

    /**
     * Set horaire
     *
     * @param \Movibe\BackendBundle\Entity\Horaire $horaire
     * @return Seance
     */
    public function setHoraire(\Movibe\BackendBundle\Entity\Horaire $horaire)
    {
        $this->horaire = $horaire;

        return $this;
    }

    /**
     * Get horaire
     *
     * @return \Movibe\BackendBundle\Entity\Horaire 
     */
    public function getHoraire()
    {
        return $this->horaire;
    }
}
