<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Departement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\DepartementRepository")
 */
class Departement
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
     * @Assert\NotBlank(message = "Le code du département est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "2",
     *      exactMessage = "Le code du département doit faire {{ limit }} caractères")
     * @ORM\Column(name="code", type="string", length=2)
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank(message = "Le nom du département est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom du département doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du département ne peut pas être plus long que {{ limit }} caractères")
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
     * @Gedmo\Slug(fields={"nom"}, separator="-",updatable=true)
     * @ORM\Column(name="nom_slug", type="string", length=255)
     */
    private $nomSlug;

    /**
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Region", inversedBy="departements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Ville", mappedBy="departement",cascade={"remove"})
     */
    private $villes;

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
     * @return Departement
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
     * @return Departement
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
     * @return Departement
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
     * Set region
     *
     * @param \Movibe\BackendBundle\Entity\Region $region
     * @return Departement
     */
    public function setRegion(\Movibe\BackendBundle\Entity\Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Movibe\BackendBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set code
     *
     * @param integer $code
     * @return Departement
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer 
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->villes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add villes
     *
     * @param \Movibe\BackendBundle\Entity\Ville $villes
     * @return Departement
     */
    public function addVille(\Movibe\BackendBundle\Entity\Ville $villes)
    {
        $this->villes[] = $villes;

        return $this;
    }

    /**
     * Remove villes
     *
     * @param \Movibe\BackendBundle\Entity\Ville $villes
     */
    public function removeVille(\Movibe\BackendBundle\Entity\Ville $villes)
    {
        $this->villes->removeElement($villes);
    }

    /**
     * Get villes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVilles()
    {
        return $this->villes;
    }

    public function getCodeNom()
    {
        return $this->getCode() . ' - ' . $this->getNom();
    }
}
