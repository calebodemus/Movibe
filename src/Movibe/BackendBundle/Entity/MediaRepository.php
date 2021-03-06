<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MediaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MediaRepository extends EntityRepository
{
    public function lastBandeAnnonce()
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT m
            FROM MovibeBackendBundle:Media m
            ORDER BY m.id DESC'
        )
            ->setMaxResults(1)
            ->getSingleResult();
        return $req;
    }
}
