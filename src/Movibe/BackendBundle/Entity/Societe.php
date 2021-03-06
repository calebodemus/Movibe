<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Societe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\SocieteRepository")
 * * @UniqueEntity(fields={"nom"},message="Cette société est déjà enregistrée dans la base de donnée."))
 */
class Societe
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
     * @Assert\NotBlank(message = "Le nom de la société est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom de la société doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de la société ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\FilmSocieteMetier", mappedBy="societe",cascade={"persist","remove"})
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
     * @return Societe
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
     * Constructor
     */
    public function __construct()
    {
        $this->filmSocieteMetiers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add filmSocieteMetiers
     *
     * @param \Movibe\BackendBundle\Entity\FilmSocieteMetier $filmSocieteMetiers
     * @return Societe
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
