<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Heure
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Movibe\BackendBundle\Entity\HeureRepository")
 * @UniqueEntity(fields={"horaire","heure"},message="Cet horaire est déjà enregistré")
 */
class Heure
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Movibe\BackendBundle\Entity\Horaire", inversedBy="heures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $horaire;

    /**
     * @var string
     * @ORM\Id
     * @Assert\Length(
     *      min = "5",
     *      max = "5",
     *      exactMessage = "L'heure doit faire {{ limit }} caractères")
     * @Assert\NotBlank(message = "L'heure est obligatoire.")
     * @ORM\Column(name="heure", type="string", length=5)
     */
    private $heure;


    /**
     * Set horaire
     *
     * @param integer $horaire
     * @return Heure
     */
    public function setHoraire($horaire)
    {
        $this->horaire = $horaire;

        return $this;
    }

    /**
     * Get horaire
     *
     * @return integer 
     */
    public function getHoraire()
    {
        return $this->horaire;
    }

    /**
     * Set heure
     *
     * @param string $heure
     * @return Heure
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return string
     */
    public function getHeure()
    {
        return $this->heure;
    }
}
