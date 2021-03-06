<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository
{
    public function lastNews()
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT MAX(n.id),n
            FROM MovibeBackendBundle:News n'
        )
            ->getSingleScalarResult();

        return $req;
    }
}
