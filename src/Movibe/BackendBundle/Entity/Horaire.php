<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Horaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\HoraireRepository")
 */
class Horaire
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
     *
     * @ORM\OneToMany(targetEntity="Movibe\BackendBundle\Entity\Heure", mappedBy="horaire",cascade={"persist","remove"})
     */
    private $heures;

    private $oldHeures;

    private $affichage;

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
     * Constructor
     */
    public function __construct()
    {
        $this->heures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add heures
     *
     * @param \Movibe\BackendBundle\Entity\Heure $heures
     * @return Horaire
     */
    public function addHeure(\Movibe\BackendBundle\Entity\Heure $heures)
    {
        $this->heures[] = $heures;
        $heures->setHoraire($this);

        return $this;
    }

    /**
     * Remove heures
     *
     * @param \Movibe\BackendBundle\Entity\Heure $heures
     */
    public function removeHeure(\Movibe\BackendBundle\Entity\Heure $heures)
    {
        $this->heures->removeElement($heures);
        $this->oldHeures[] = $heures;
    }

    /**
     * Get heures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHeures()
    {
        return $this->heures;
    }

    public function setHeures()
    {
        $this->heures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getOldHeures()
    {
        return $this->oldHeures;
    }

    public function getAffichage()
    {
        $heures = $this->getHeures();
        $this->affichage = "";

        foreach ($heures as $key => $heure )
        {
            if ($heures->count() - 1 == $key)
            {
                $this->affichage .= $heure->getHeure();
            }
            else
            {
                $this->affichage .= $heure->getHeure() . ' | ';
            }
        }

        return $this->affichage;
    }

    public function setAffichage($affichage)
    {
        return $this->affichage = $affichage;
    }
}
