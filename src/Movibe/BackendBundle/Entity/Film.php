<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Film
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\FilmRepository")
 */
class Film
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
     * @Assert\NotBlank(message = "Le titre du film est obligatoire.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le titre du film doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le titre du film ne peut pas être plus long que {{ limit }} caractères")
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_original", type="string", length=255)
     */
    private $titreOriginal;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message = "La date de sortie du film est obligatoire.")
     * @ORM\Column(name="date_sortie", type="datetime")
     */
    private $dateSortie;

    /**
     * @var string
     *
     * @ORM\Column(name="synopsis", type="string", length=4096)
     */
    private $synopsis;

    /**
     * @var string
     *
     * @ORM\Column(name="bande_originale", type="string", length=1024, nullable=true)
     */
    private $bandeOriginale;

    /**
     * @var integer
     *
     * @ORM\Column(name="budget", type="integer")
     */
    private $budget;

    /**
     * @var integer
     *
     * @ORM\Column(name="devise", type="integer")
     */
    private $devise;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee_production", type="integer")
     */
    private $anneeProduction;

    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;

    /**
     * @var integer
     *
     * @ORM\Column(name="visa", type="integer")
     */
    private $visa;

    /**
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Image",cascade={"persist","remove"}, mappedBy="film")
     */
    private $images;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Couleur", inversedBy="films")
     */
    private $couleur;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Movibe\BackendBundle\Entity\Pays")
     * @ORM\JoinTable(name="film_pays",
     *      joinColumns={@ORM\JoinColumn(name="film_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="pays_code", referencedColumnName="code")}
     *      )
     */
    private $pays;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Movibe\BackendBundle\Entity\Genre", inversedBy="films")
     * @ORM\JoinTable(name="film_genre")
     */
    private $genres;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Langue", inversedBy="films")
     */
    private $langue;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\TypeFilm", inversedBy="films")
     */
    private $typeFilm;


    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Critique", mappedBy="film",cascade={"persist","remove"})
     */
    private $critiques;

    private $promotion;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Media", mappedBy="film",cascade={"persist","remove"})
     */
    private $medias;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Casting", mappedBy="film",cascade={"persist","remove"})
     */
     private $castings;

    private $acteurs;
    private $realisateurs;
    private $scenaristes;
    private $producteurs;
    private $equipeTech;
    private $distributeurs;
    private $compositeurs;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\FilmSocieteMetier", mappedBy="film",cascade={"persist","remove"})
     */
    private $filmSocieteMetiers;

    private $affiches;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\News", mappedBy="film",cascade={"persist","remove"})
     */
    private $listNews;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Commentaire", mappedBy="film",cascade={"remove"})
     */
    private $commentaires;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Seance", mappedBy="film",cascade={"persist", "remove"})
     */
    private $seances;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\BoxOffice", mappedBy="film",cascade={"persist", "remove"})
     */
    private $boxOffices;

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
     * Set titre
     *
     * @param string $titre
     * @return Film
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set dateSortie
     *
     * @param \DateTime $dateSortie
     * @return Film
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * Get dateSortie
     *
     * @return \DateTime 
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }

    /**
     * Set synopsis
     *
     * @param string $synopsis
     * @return Film
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * Get synopsis
     *
     * @return string 
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set bandeOriginale
     *
     * @param string $bandeOriginale
     * @return Film
     */
    public function setBandeOriginale($bandeOriginale)
    {
        $this->bandeOriginale = $bandeOriginale;

        return $this;
    }

    /**
     * Get bandeOrginale
     *
     * @return string 
     */
    public function getBandeOriginale()
    {
        return $this->bandeOriginale;
    }

    /**
     * Set budget
     *
     * @param integer $budget
     * @return Film
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return integer 
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set devise
     *
     * @param integer $devise
     * @return Film
     */
    public function setDevise($devise)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get devise
     *
     * @return integer 
     */
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return Film
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Film
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set visa
     *
     * @param integer $visa
     * @return Film
     */
    public function setVisa($visa)
    {
        $this->visa = $visa;

        return $this;
    }

    /**
     * Get visa
     *
     * @return integer 
     */
    public function getVisa()
    {
        return $this->visa;
    }


    /**
     * Set titreOriginal
     *
     * @param string $titreOriginal
     * @return Film
     */
    public function setTitreOriginal($titreOriginal)
    {
        $this->titreOriginal = $titreOriginal;

        return $this;
    }

    /**
     * Get titreOriginal
     *
     * @return string 
     */
    public function getTitreOriginal()
    {
        return $this->titreOriginal;
    }

    /**
     * Set anneeProduction
     *
     * @param integer $anneeProduction
     * @return Film
     */
    public function setAnneeProduction($anneeProduction)
    {
        $this->anneeProduction = $anneeProduction;

        return $this;
    }

    /**
     * Get anneeProduction
     *
     * @return integer 
     */
    public function getAnneeProduction()
    {
        return $this->anneeProduction;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     * @return Film
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->critiques = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pays = new \Doctrine\Common\Collections\ArrayCollection();
        $this->filmSocieteMetiers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add images
     *
     * @param \Movibe\BackendBundle\Entity\Image $images
     * @return Film
     */
    public function addImage(\Movibe\BackendBundle\Entity\Image $images)
    {
        $this->images[] = $images;
        $images->setFilm($this);

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

    public function setImages(array $images)
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection($images);

        foreach ($images as $image) {
            $image->setFilm($this);
        }

        $this->images = $images;
    }

    /**
     * Set couleur
     *
     * @param \Movibe\BackendBundle\Entity\Couleur $couleur
     * @return Film
     */
    public function setCouleur(\Movibe\BackendBundle\Entity\Couleur $couleur = null)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return \Movibe\BackendBundle\Entity\Couleur 
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set langue
     *
     * @param \Movibe\BackendBundle\Entity\Langue $langue
     * @return Film
     */
    public function setLangue(\Movibe\BackendBundle\Entity\Langue $langue = null)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return \Movibe\BackendBundle\Entity\Langue 
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Set typeFilm
     *
     * @param \Movibe\BackendBundle\Entity\TypeFilm $typeFilm
     * @return Film
     */
    public function setTypeFilm(\Movibe\BackendBundle\Entity\TypeFilm $typeFilm = null)
    {
        $this->typeFilm = $typeFilm;

        return $this;
    }

    /**
     * Get typeFilm
     *
     * @return \Movibe\BackendBundle\Entity\TypeFilm 
     */
    public function getTypeFilm()
    {
        return $this->typeFilm;
    }

    /**
     * Add genres
     *
     * @param \Movibe\BackendBundle\Entity\Genre $genres
     * @return Film
     */
    public function addGenre(\Movibe\BackendBundle\Entity\Genre $genres)
    {
        $this->genres[] = $genres;

        return $this;
    }

    /**
     * Remove genres
     *
     * @param \Movibe\BackendBundle\Entity\Genre $genres
     */
    public function removeGenre(\Movibe\BackendBundle\Entity\Genre $genres)
    {
        $this->genres->removeElement($genres);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Add pays
     *
     * @param \Movibe\BackendBundle\Entity\Pays $pays
     * @return Film
     */
    public function addPay(\Movibe\BackendBundle\Entity\Pays $pays)
    {
        $this->pays[] = $pays;

        return $this;
    }

    /**
     * Remove pays
     *
     * @param \Movibe\BackendBundle\Entity\Pays $pays
     */
    public function removePay(\Movibe\BackendBundle\Entity\Pays $pays)
    {
        $this->pays->removeElement($pays);
    }

    /**
     * Get pays
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Add critiques
     *
     * @param \Movibe\BackendBundle\Entity\Critique $critiques
     * @return Film
     */
    public function addCritique(\Movibe\BackendBundle\Entity\Critique $critiques)
    {
        $this->critiques[] = $critiques;
        $critiques->setFilm($this);

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

    public function setCritiques()
    {
        $this->critiques = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setPromotion(\Movibe\BackendBundle\Entity\Image $promotion)
    {
        $this->promotion = $promotion;
        return $this;
    }

    public function getPromotion()
    {
        return $this->promotion;
    }


    /**
     * Add medias
     *
     * @param \Movibe\BackendBundle\Entity\Media $medias
     * @return Film
     */
    public function addMedia(\Movibe\BackendBundle\Entity\Media $medias)
    {
        $this->medias[] = $medias;
        $medias->setFilm($this);

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \Movibe\BackendBundle\Entity\Media $medias
     */
    public function removeMedia(\Movibe\BackendBundle\Entity\Media $medias)
    {
        $this->medias->removeElement($medias);
    }

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Add castings
     *
     * @param \Movibe\BackendBundle\Entity\Casting $castings
     * @return Film
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

    public function setCastings($castings)
    {
        $this->castings = $castings;
    }


    public function loopingCollectionCasting($tab)
    {
        $i=0;

        while (isset($tab[$i]))
        {
            $casting = new \Movibe\BackendBundle\Entity\Casting;
            $casting->setFilm($this);
            $occurence = $tab[$i];

            $casting->setPersonne($occurence->getPersonne());
            $casting->setRole($occurence->getRole());
            $casting->setMetier($occurence->getMetier());

            $this->addCasting($casting);
            $i++;
        }
    }


    public function getActeurs()
    {
        return $this->acteurs;
    }
    public function setActeurs($acteurs)
    {
        $this->loopingCollectionCasting($acteurs);
    }
    public function addActeur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->acteurs[] = $casting;

        return $this;
    }
    public function removeActeur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->acteurs->removeElement($casting);
    }


    public function getRealisateurs()
    {
        return $this->realisateurs;
    }
    public function setRealisateurs($realisateurs)
    {
        $this->loopingCollectionCasting($realisateurs);
    }
    public function addRealisateur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->realisateurs[] = $casting;

        return $this;
    }
    public function removeRealisateur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->realisateurs->removeElement($casting);
    }

    public function getScenaristes()
    {
        return $this->scenaristes;
    }
    public function setScenaristes($scenaristes)
    {
        $this->loopingCollectionCasting($scenaristes);
    }
    public function addScenariste(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->scenaristes[] = $casting;

        return $this;
    }
    public function removeScenariste(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->scenaristes->removeElement($casting);
    }

    public function getProducteurs()
    {
        return $this->producteurs;
    }
    public function setProducteurs($producteurs)
    {
        $this->loopingCollectionCasting($producteurs);
    }
    public function addProducteur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->producteurs[] = $casting;

        return $this;
    }
    public function removeProducteur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->producteurs->removeElement($casting);
    }

    public function getEquipeTech()
    {
        return $this->equipeTech;
    }
    public function setEquipeTech($equipeTech)
    {
        $this->loopingCollectionCasting($equipeTech);
    }
    public function addEquipeTech(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->equipeTech[] = $casting;

        return $this;
    }
    public function removeEquipeTech(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->equipeTech->removeElement($casting);
    }

    public function getDistributeurs()
    {
        return $this->distributeurs;
    }
    public function setDistributeurs($distributeurs)
    {
        $this->loopingCollectionCasting($distributeurs);
    }
    public function addDistributeur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->distributeurs[] = $casting;

        return $this;
    }
    public function removeDistributeur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->distributeurs->removeElement($casting);
    }

    public function getCompositeurs()
    {
        return $this->compositeurs;
    }
    public function setCompositeurs($compositeurs)
    {
        $this->loopingCollectionCasting($compositeurs);
    }
    public function addCompositeur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->compositeurs[] = $casting;

        return $this;
    }
    public function removeCompositeur(\Movibe\BackendBundle\Entity\Casting $casting)
    {
        $this->compositeurs->removeElement($casting);
    }

    public function initCastings()
    {
        $this->castings = new \Doctrine\Common\Collections\ArrayCollection();

        $this->loopingCollectionCasting($this->getActeurs());
        $this->loopingCollectionCasting($this->getRealisateurs());
        $this->loopingCollectionCasting($this->getProducteurs());
        $this->loopingCollectionCasting($this->getScenaristes());
        $this->loopingCollectionCasting($this->getCompositeurs());
        $this->loopingCollectionCasting($this->getEquipeTech());
        $this->loopingCollectionCasting($this->getDistributeurs());
    }

    public function dispatchCasting()
    {
        foreach ($this->castings as $casting)
        {
            switch ($casting->getMetier()->getParent()->getId())
            {
                case 1:
                    $this->addActeur($casting);
                    break;
                case 2:
                    $this->addScenariste($casting);
                    break;
                case 3:
                    $this->addEquipeTech($casting);
                    break;
                case 5:
                    $this->addActeur($casting);
                    break;
                case 6:
                    $this->addRealisateur($casting);
                    break;
                case 58:
                    $this->addDistributeur($casting);
                    break;
                case 59:
                    $this->addCompositeur($casting);
                    break;
            }
        }
    }

    /**
     * Add filmSocieteMetiers
     *
     * @param \Movibe\BackendBundle\Entity\FilmSocieteMetier $filmSocieteMetiers
     * @return Film
     */
    public function addFilmSocieteMetier(\Movibe\BackendBundle\Entity\FilmSocieteMetier $filmSocieteMetiers)
    {
        $this->filmSocieteMetiers[] = $filmSocieteMetiers;
        $filmSocieteMetiers->setFilm($this);

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

    public function setFilmSocieteMetiers()
    {
        $this->filmSocieteMetiers = new \Doctrine\Common\Collections\ArrayCollection();
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


    public function addAffiche(\Movibe\BackendBundle\Entity\Image $image)
    {
        $this->affiches[] = $image;
        return $this;
    }

    public function removeAffiche(\Movibe\BackendBundle\Entity\Image $image)
    {
        $this->affiches->removeElement($image);
    }
    public function getAffiches()
    {
        return $this->affiches;
    }
    public function searchAffiches()
    {
        foreach ($this->images as $image)
        {
            if ($image->getAffiche())
            {
                $this->addAffiche($image);
            }
        }
    }

    public function imagesPath($thumbnail = null)
    {
        foreach ($this->images as $image)
        {
            $image->setPath($thumbnail);
        }
    }

    public function promotionPersonnes()
    {
        foreach ($this->getCastings() as $casting)
        {
            $personne = $casting->getPersonne();
            $personne->setPromotion();
        }
    }

    public function verificationRemoveElement( $oldTab, $newTab)
    {
        $tabDelete = array();

        foreach ($oldTab as $oldElement)
        {
            $delete = true;
            foreach ($newTab as $newElement)
            {
                if ($newElement === $oldElement)
                {
                    $delete = false;
                    break;
                }
            }

            if ($delete)
            {
                $tabDelete[] = $oldElement;
            }
        }

        return $tabDelete;
    }


    /**
     * Add listNews
     *
     * @param \Movibe\BackendBundle\Entity\News $listNews
     * @return Film
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

    public function to_json()
    {
        return json_encode(array(
            'id' => $this->getId(),
            'titre' => $this->getTitre(),
            'path' => $this->getPromotion()->getWebPath('small'),
            'description' => $this->getSynopsis(),
            'type' => 'film'
        ));
    }

    /**
     * Add commentaires
     *
     * @param \Movibe\BackendBundle\Entity\Commentaire $commentaires
     * @return Film
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

    /**
     * Add seances
     *
     * @param \Movibe\BackendBundle\Entity\Seance $seances
     * @return Film
     */
    public function addSeance(\Movibe\BackendBundle\Entity\Seance $seances)
    {
        $this->seances[] = $seances;
        $seances->setFilm($this);

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

    /**
     * Add boxOffices
     *
     * @param \Movibe\BackendBundle\Entity\BoxOffice $boxOffices
     * @return Film
     */
    public function addBoxOffice(\Movibe\BackendBundle\Entity\BoxOffice $boxOffices)
    {
        $this->boxOffices[] = $boxOffices;
        $boxOffices->setFilm($this);

        return $this;
    }

    /**
     * Remove boxOffices
     *
     * @param \Movibe\BackendBundle\Entity\BoxOffice $boxOffices
     */
    public function removeBoxOffice(\Movibe\BackendBundle\Entity\BoxOffice $boxOffices)
    {
        $this->boxOffices->removeElement($boxOffices);
    }

    /**
     * Get boxOffices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBoxOffices()
    {
        return $this->boxOffices;
    }
}
