<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Presse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\PresseRepository")
 * @UniqueEntity(fields={"nom"},message="Cette presse est déjà enregistré")
 */
class Presse
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
     * @Assert\NotBlank(message = "Le nom du presse est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom de la presse doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de la presse ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Critique", mappedBy="presse",cascade={"remove"})
     */
    private $critiques;


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
     * @return Presse
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
        $this->critiques = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add critiques
     *
     * @param \Movibe\BackendBundle\Entity\Critique $critiques
     * @return Presse
     */
    public function addCritique(\Movibe\BackendBundle\Entity\Critique $critiques)
    {
        $this->critiques[] = $critiques;

        return $this;
    }

    /**
     * Remove critiques
     *
     * @param \Movibe\BackendBundle\Entity\Critique $critiques
     */
    public function removeCritique(\Movibe\BackendBundle\Entity\Critique $critiques)
    {
        $this->critiques->removeElement($critiques);
    }

    /**
     * Get critiques
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCritiques()
    {
        return $this->critiques;
    }
}
