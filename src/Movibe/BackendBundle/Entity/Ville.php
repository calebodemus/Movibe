<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Ville
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\VilleRepository")
 */
class Ville
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
     * @Assert\NotBlank(message = "Le nom de la ville est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom de la ville doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de la ville ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_uppercase", type="string", length=255)
     */
    private $nomUppercase;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_slug", type="string", length=255)
     */
    private $nomSlug;

    /**
     * @var string
     * @Assert\NotBlank(message = "Le code-postal de la ville est obligatoire.")
     * @Assert\Length(
     *      min = "5",
     *      max = "5",
     *      exactMessage = "Le code-postal de la ville doit faire {{ limit }} caractères")
     * @ORM\Column(name="code_postal", type="string", length=5)
     */
    private $codePostal;

    /**
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Departement", inversedBy="villes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departement;


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
     * @return Ville
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
     * Set nomUppercase
     *
     * @param string $nomUppercase
     * @return Ville
     */
    public function setNomUppercase($nomUppercase)
    {
        $this->nomUppercase = $nomUppercase;

        return $this;
    }

    /**
     * Get nomUppercase
     *
     * @return string 
     */
    public function getNomUppercase()
    {
        return $this->nomUppercase;
    }

    /**
     * Set nomSlug
     *
     * @param string $nomSlug
     * @return Ville
     */
    public function setNomSlug($nomSlug)
    {
        $this->nomSlug = $nomSlug;

        return $this;
    }

    /**
     * Get nomSlug
     *
     * @return string 
     */
    public function getNomSlug()
    {
        return $this->nomSlug;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return Ville
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set departement
     *
     * @param \Movibe\BackendBundle\Entity\Departement $departement
     * @return Ville
     */
    public function setDepartement(\Movibe\BackendBundle\Entity\Departement $departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \Movibe\BackendBundle\Entity\Departement 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    public function getCodePostalNom()
    {
        return $this->getCodePostal() . ' - ' . $this->getNom();
    }

    public function __toString()
    {
       return $this->getNom();
    }
}
