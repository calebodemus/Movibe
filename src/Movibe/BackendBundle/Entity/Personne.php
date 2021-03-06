<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Personne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\PersonneRepository")
 */
class Personne
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
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var array
     *
     * @ORM\Column(name="pseudos", type="simple_array", nullable=true)
     */
    private $pseudos;

    /**
     * @var string
     *
     * @ORM\Column(name="biographie", type="string", length=4096)
     */
    private $biographie;


    /**
     * @var boolean
     *
     * @ORM\Column(name="sexe", type="boolean")
     */
    private $sexe;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Ville", inversedBy="personnes")
     */
    private $villeNaissance;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Pays", inversedBy="personnes")
     * @ORM\JoinColumn(name="pays_code", referencedColumnName="code")
     */
    private $nationalite;

    /**
     * @Assert\Valid()
     * @ORM\ManyToMany(targetEntity="Movibe\BackendBundle\Entity\Image",cascade={"persist","remove"}, mappedBy="personnes")
     * @ORM\JoinTable(name="image_personne")
     */
    private $images;

    /**
     * @Gedmo\Slug(fields={"prenom", "nom"}, separator="-",updatable=true)
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    private $promotion;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Casting", mappedBy="personne",cascade={"persist","remove"})
     */
    private $castings;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Movibe\BackendBundle\Entity\News", mappedBy="personnes",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     * @ORM\JoinTable(name="news_personne")
     */
    private $listNews;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Commentaire", mappedBy="personne",cascade={"remove"})
     */
    private $commentaires;

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
     * Set prenom
     *
     * @param string $prenom
     * @return Personne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Personne
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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Personne
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set pseudos
     *
     * @param array $pseudos
     * @return Personne
     */
    public function setPseudos($pseudos)
    {
        $this->pseudos = $pseudos;

        return $this;
    }

    /**
     * Get pseudos
     *
     * @return array 
     */
    public function getPseudos()
    {
        return $this->pseudos;
    }

    /**
     * Set biographie
     *
     * @param string $biographie
     * @return Personne
     */
    public function setBiographie($biographie)
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get biographie
     *
     * @return string 
     */
    public function getBiographie()
    {
        return $this->biographie;
    }

    /**
     * Set sexe
     *
     * @param boolean $sexe
     * @return Personne
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return boolean 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set villeNaissance
     *
     * @param \Movibe\BackendBundle\Entity\Ville $villeNaissance
     * @return Personne
     */
    public function setVilleNaissance(\Movibe\BackendBundle\Entity\Ville $villeNaissance = null)
    {
        $this->villeNaissance = $villeNaissance;

        return $this;
    }

    /**
     * Get villeNaissance
     *
     * @return \Movibe\BackendBundle\Entity\Ville 
     */
    public function getVilleNaissance()
    {
        return $this->villeNaissance;
    }

    /**
     * Set nationalite
     *
     * @param \Movibe\BackendBundle\Entity\Pays $nationalite
     * @return Personne
     */
    public function setNationalite(\Movibe\BackendBundle\Entity\Pays $nationalite = null)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return \Movibe\BackendBundle\Entity\Pays 
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
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add images
     *
     * @param \Movibe\BackendBundle\Entity\Image $images
     * @return Personne
     */
    public function addImage(\Movibe\BackendBundle\Entity\Image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Movibe\BackendBundle\Entity\Image $images
     */
    public function removeImage(\Movibe\BackendBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    public function verifImage(\Movibe\BackendBundle\Entity\Image $check)
    {
        foreach ($this->images as $image)
        {
            if ($image === $check)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Personne
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function setPromotion()
    {
        foreach ($this->getImages() as $image)
        {
            if ($image->getPromotion())
            {
                $image->setPath('small');
                return $this->promotion = $image;
            }
        }
    }

    public function getPromotion()
    {
        return $this->promotion;
    }

    public function searchPromotion()
    {
        foreach ($this->images as $image)
        {
            if ($image->getPromotion())
            {
                $this->setPromotion($image);
                return true;
            }
        }
        return false;
    }

    /**
     * Add castings
     *
     * @param \Movibe\BackendBundle\Entity\Casting $castings
     * @return Personne
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

    public function __toString()
    {
        return $this->promotion->getPath();
    }

    public function to_json()
    {
         return json_encode(array(
            'id' => $this->getId(),
            'titre' => $this->getPrenom() . " " . $this->getNom(),
            'path' => $this->getPromotion()->getWebPath('small'),
            'description' => $this->getBiographie(),
            'type' => 'personne'
        ));
    }

    /**
     * Add listNews
     *
     * @param \Movibe\BackendBundle\Entity\News $listNews
     * @return Personne
     */
    public function addListNews(\Movibe\BackendBundle\Entity\News $listNews)
    {
        $this->listNews[] = $listNews;

        return $this;
    }

    /**
     * Remove listNews
     *
     * @param \Movibe\BackendBundle\Entity\News $listNews
     */
    public function removeListNews(\Movibe\BackendBundle\Entity\News $listNews)
    {
        $this->listNews->removeElement($listNews);
    }

    /**
     * Get listNews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getListNews()
    {
        return $this->listNews;
    }

    /**
     * Add commentaires
     *
     * @param \Movibe\BackendBundle\Entity\Commentaire $commentaires
     * @return Personne
     */
    public function addCommentaire(\Movibe\BackendBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \Movibe\BackendBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\Movibe\BackendBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
}
