<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Region
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\RegionRepository")
 */
class Region
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
     * @Assert\NotBlank(message = "Le nom de la region est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom de la region doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de la region ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(name="nom_uppercase", type="string", length=255)
     */
    private $nomUppercase;

    /**
     * @var string
     * @Gedmo\Slug(fields={"nom"}, separator="-",updatable=true)
     * @ORM\Column(name="nom_slug", type="string", length=255)
     */
    private $nomSlug;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Pays", inversedBy="regions")
     * @ORM\JoinColumn(nullable=false, name="pays_code", referencedColumnName="code")
     */
    private $pays;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Departement", mappedBy="region",cascade={"remove"})
     */
    private $departements;


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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * Set pays
     *
     * @param \Movibe\BackendBundle\Entity\Pays $pays
     * @return Region
     */
    public function setPays(\Movibe\BackendBundle\Entity\Pays $pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \Movibe\BackendBundle\Entity\Pays 
     */
    public function getPays()
    {
        return $this->pays;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->departements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add departements
     *
     * @param \Movibe\BackendBundle\Entity\Departement $departements
     * @return Region
     */
    public function addDepartement(\Movibe\BackendBundle\Entity\Departement $departements)
    {
        $this->departements[] = $departements;

        return $this;
    }

    /**
     * Remove departements
     *
     * @param \Movibe\BackendBundle\Entity\Departement $departements
     */
    public function removeDepartement(\Movibe\BackendBundle\Entity\Departement $departements)
    {
        $this->departements->removeElement($departements);
    }

    /**
     * Get departements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepartements()
    {
        return $this->departements;
    }
}
