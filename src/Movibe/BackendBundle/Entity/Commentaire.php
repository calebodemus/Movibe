<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\Column(name="comment", type="string", length=10240)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="datetime")
     */
    private $dateModification;

    /**
     * @var integer
     *
     * @ORM\Column(name="votePour", type="integer")
     */
    private $votePour;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteContre", type="integer")
     */
    private $voteContre;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Film", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $film;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Personne", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $personne;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\User", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


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
     * Set comment
     *
     * @param string $comment
     * @return Commentaire
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Commentaire
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     * @return Commentaire
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime 
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set votePour
     *
     * @param integer $votePour
     * @return Commentaire
     */
    public function setVotePour($votePour)
    {
        $this->votePour = $votePour;

        return $this;
    }

    /**
     * Get votePour
     *
     * @return integer 
     */
    public function getVotePour()
    {
        return $this->votePour;
    }

    /**
     * Set voteContre
     *
     * @param integer $voteContre
     * @return Commentaire
     */
    public function setVoteContre($voteContre)
    {
        $this->voteContre = $voteContre;

        return $this;
    }

    /**
     * Get voteContre
     *
     * @return integer 
     */
    public function getVoteContre()
    {
        return $this->voteContre;
    }

    /**
     * Set film
     *
     * @param \Movibe\BackendBundle\Entity\Film $film
     * @return Commentaire
     */
    public function setFilm(\Movibe\BackendBundle\Entity\Film $film = null)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return \Movibe\BackendBundle\Entity\Film 
     */
    public function getFilm()
    {
        return $this->film;
    }

    /**
     * Set personne
     *
     * @param \Movibe\BackendBundle\Entity\Personne $personne
     * @return Commentaire
     */
    public function setPersonne(\Movibe\BackendBundle\Entity\Personne $personne = null)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \Movibe\BackendBundle\Entity\Personne 
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set user
     *
     * @param \Movibe\BackendBundle\Entity\User $user
     * @return Commentaire
     */
    public function setUser(\Movibe\BackendBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Movibe\BackendBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
