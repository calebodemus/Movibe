<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Search
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\SearchRepository")
 */
class Search
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $categorie;
    private $recherche;
    private $resultat;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setRecherche($recherche)
    {
        $this->recherche = $recherche;

        return $this;
    }

    public function getRecherche()
    {
        return $this->recherche;
    }

    public function setResultat($resultat,$type)
    {
        $this->resultat[$type] = $resultat;

        return $this;
    }

    public function getResultat()
    {
        return $this->resultat;
    }

}
