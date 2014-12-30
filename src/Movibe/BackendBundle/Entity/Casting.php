<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Casting
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\CastingRepository")
 */
class Casting
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
     * @ORM\Column(name="role", type="string", length=255, nullable=true)
     */
    private $role;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Film", inversedBy="castings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $film;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Personne", inversedBy="castings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personne;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Metier", inversedBy="castings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $metier;




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
     * Set role
     *
     * @param string $role
     * @return Casting
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set film
     *
     * @param \Movibe\BackendBundle\Entity\Film $film
     * @return Casting
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
     * Set personne
     *
     * @param \Movibe\BackendBundle\Entity\Personne $personne
     * @return Casting
     */
    public function setPersonne(\Movibe\BackendBundle\Entity\Personne $personne)
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
     * Set metier
     *
     * @param \Movibe\BackendBundle\Entity\Metier $metier
     * @return Casting
     */
    public function setMetier(\Movibe\BackendBundle\Entity\Metier $metier)
    {
        $this->metier = $metier;

        return $this;
    }

    /**
     * Get metier
     *
     * @return \Movibe\BackendBundle\Entity\Metier 
     */
    public function getMetier()
    {
        return $this->metier;
    }
}
