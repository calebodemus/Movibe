<?php
// src/Acme/UserBundle/Entity/User.php

namespace Movibe\BackendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Critique", mappedBy="user",cascade={"remove"})
     */
    private $critiques;

    /**
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Commentaire", mappedBy="user",cascade={"remove"})
     */
    private $commentaires;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

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
     * Add critiques
     *
     * @param \Movibe\BackendBundle\Entity\Critique $critiques
     * @return User
     */
    public function addCritique(\Movibe\BackendBundle\Entity\Critique $critiques)
    {
        $this->critiques[] = $critiques;

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

    /**
     * Add commentaires
     *
     * @param \Movibe\BackendBundle\Entity\Commentaire $commentaires
     * @return User
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
