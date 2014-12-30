<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cinema
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\CinemaRepository")
 */
class Cinema
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
     * @Assert\NotBlank(message = "Le nom du cinema est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom du cinema doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du cinema ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message = "L'adresse du cinema est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "L'adresse du cinema doit faire au moins {{ limit }} caractères",
     *      maxMessage = "L'adresse du cinema ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Ville")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Seance", mappedBy="cinema",cascade={"persist", "remove"})
     */
    private $seances;

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
     * @return Cinema
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
     * Set adresse
     *
     * @param string $adresse
     * @return Cinema
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville
     *
     * @param \Movibe\BackendBundle\Entity\Ville $ville
     * @return Cinema
     */
    public function setVille(\Movibe\BackendBundle\Entity\Ville $ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \Movibe\BackendBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seances = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add seances
     *
     * @param \Movibe\BackendBundle\Entity\Seance $seances
     * @return Cinema
     */
    public function addSeance(\Movibe\BackendBundle\Entity\Seance $seances)
    {
        $this->seances[] = $seances;
        $seances->setCinema($this);

        return $this;
    }

    /**
     * Remove seances
     *
     * @param \Movibe\BackendBundle\Entity\Seance $seances
     */
    public function removeSeance(\Movibe\BackendBundle\Entity\Seance $seances)
    {
        $this->seances->removeElement($seances);
    }

    /**
     * Get seances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeances()
    {
        return $this->seances;
    }

    public function setSeances()
    {
        return $this->seances = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function to_json()
    {
        return json_encode(array(
            'id' => $this->getId(),
            'titre' => $this->getNom(),
            'path' => 'http://placehold.it/200x200',
            'description' => $this->getAdresse() . $this->getVille()->getNom() . $this->getVille()->getCodePostal() ,
            'type' => 'cinema'
        ));
    }

    public function __toString()
    {
       return $this->nom;
    }
}
