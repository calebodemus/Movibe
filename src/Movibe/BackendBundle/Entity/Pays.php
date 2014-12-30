<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pays
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\PaysRepository")
 */
class Pays
{
    /**
     * @var string
     * @ORM\Id
     * @Assert\NotBlank(message = "Le code Pays est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "2",
     *      exactMessage = "Le code Pays doit faire {{ limit }} caractères")
     * @ORM\Column(name="code", type="string", length=2)
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank(message = "Le nom du pays est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom du pays doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du pays ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message = "Le nom de la nationalité est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom de la nationalité doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de la nationalité ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Region", mappedBy="pays",cascade={"remove"})
     */
    private $regions;

    /**
     * Set code
     *
     * @param string $code
     * @return Pays
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Pays
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
     * Set nationalite
     *
     * @param string $nationalite
     * @return Pays
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add regions
     *
     * @param \Movibe\BackendBundle\Entity\Region $regions
     * @return Pays
     */
    public function addRegion(\Movibe\BackendBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;

        return $this;
    }

    /**
     * Remove regions
     *
     * @param \Movibe\BackendBundle\Entity\Region $regions
     */
    public function removeRegion(\Movibe\BackendBundle\Entity\Region $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }
}
