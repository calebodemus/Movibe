<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Critique
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\CritiqueRepository")
 */
class Critique
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
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=1024)
     */
    private $commentaire;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Film", inversedBy="critiques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $film;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Presse", inversedBy="critiques")
     * @ORM\JoinColumn(nullable=true)
     */
    private $presse;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\User", inversedBy="critiques")
     * @ORM\JoinColumn(nullable=true)
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
     * Set note
     *
     * @param integer $note
     * @return Critique
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Critique
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set film
     *
     * @param \Movibe\BackendBundle\Entity\Film $film
     * @return Critique
     */
    public function setFilm(\Movibe\BackendBundle\Entity\Film $film)
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
     * Set presse
     *
     * @param \Movibe\BackendBundle\Entity\Presse $presse
     * @return Critique
     */
    public function setPresse(\Movibe\BackendBundle\Entity\Presse $presse)
    {
        $this->presse = $presse;

        return $this;
    }

    /**
     * Get presse
     *
     * @return \Movibe\BackendBundle\Entity\Presse 
     */
    public function getPresse()
    {
        return $this->presse;
    }

    /**
     * Set user
     *
     * @param \Movibe\BackendBundle\Entity\User $user
     * @return Critique
     */
    public function setUser(\Movibe\BackendBundle\Entity\User $user = null)
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
