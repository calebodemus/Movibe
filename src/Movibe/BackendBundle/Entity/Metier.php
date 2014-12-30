<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Metier
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\MetierRepository")
 * @UniqueEntity(fields={"nom","parent"},message="Ce métier est déjà enregistrée pour le parent qui vous avez indiqué."))
 */
class Metier
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
     * @var string
     * @Assert\NotBlank(message = "Le nom du métier est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom du métier doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du métier ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Metier", inversedBy="id")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Casting", mappedBy="metier",cascade={"persist","remove"})
     */
    private $castings;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\FilmSocieteMetier", mappedBy="metier",cascade={"persist","remove"})
     */
    private $filmSocieteMetiers;


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
     * Set nom
     *
     * @param string $nom
     * @return Metier
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }


    /**
     * Set parent
     *
     * @param \Movibe\BackendBundle\Entity\Metier $parent
     * @return Metier
     */
    public function setParent(\Movibe\BackendBundle\Entity\Metier $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Movibe\BackendBundle\Entity\Metier
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->castings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add castings
     *
     * @param \Movibe\BackendBundle\Entity\Casting $castings
     * @return Metier
     */
    public function addCasting(\Movibe\BackendBundle\Entity\Casting $castings)
    {
        $this->castings[] = $castings;

        return $this;
    }

    /**
     * Remove castings
     *
     * @param \Movibe\BackendBundle\Entity\Casting $castings
     */
    public function removeCasting(\Movibe\BackendBundle\Entity\Casting $castings)
    {
        $this->castings->removeElement($castings);
    }

    /**
     * Get castings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCastings()
    {
        return $this->castings;
    }

    /**
     * Add filmSocieteMetiers
     *
     * @param \Movibe\BackendBundle\Entity\FilmSocieteMetier $filmSocieteMetiers
     * @return Metier
     */
    public function addFilmSocieteMetier(\Movibe\BackendBundle\Entity\FilmSocieteMetier $filmSocieteMetiers)
    {
        $this->filmSocieteMetiers[] = $filmSocieteMetiers;

        return $this;
    }

    /**
     * Remove filmSocieteMetiers
     *
     * @param \Movibe\BackendBundle\Entity\FilmSocieteMetier $filmSocieteMetiers
     */
    public function removeFilmSocieteMetier(\Movibe\BackendBundle\Entity\FilmSocieteMetier $filmSocieteMetiers)
    {
        $this->filmSocieteMetiers->removeElement($filmSocieteMetiers);
    }

    /**
     * Get filmSocieteMetiers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilmSocieteMetiers()
    {
        return $this->filmSocieteMetiers;
    }
}
