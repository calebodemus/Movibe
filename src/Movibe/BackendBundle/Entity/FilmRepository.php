<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FilmRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FilmRepository extends EntityRepository
{
    public function promotionImage($id)
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT i
             FROM MovibeBackendBundle:Image i
             WHERE i.film = :id
             AND i.promotion = true')
            ->setParameter('id',$id)
            ->getResult();

        return $req;
    }

    public function inventaireNbFilmByGenres()
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT g.nom, COUNT(f) AS nombre
            FROM MovibeBackendBundle:Film f
            JOIN f.genres g
            GROUP BY g.nom'
        )
            ->getResult();

        return $req;
    }

    public function nombreTotalFilm()
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT COUNT(f) nombre
            FROM MovibeBackendBundle:Film f'
        )
            ->getSingleScalarResult();

        return $req;
    }
}