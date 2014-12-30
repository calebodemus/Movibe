<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RegionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RegionRepository extends EntityRepository
{
    public function listRegionByPays($id)
    {
        $req = $this->getEntityManager()->createQuery('SELECT r FROM MovibeBackendBundle:Region r WHERE r.pays = :id ORDER BY r.nom')
            ->setParameter('id', $id)->getResult();

        return $req;
    }
}
