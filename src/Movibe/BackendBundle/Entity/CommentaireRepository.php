<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommentaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends EntityRepository
{
    public function sortDescByDate($type, $idt)
    {
        switch ($type)
        {
            case 'film':
                $req = $this->getEntityManager()->createQuery('SELECT c FROM MovibeBackendBundle:Commentaire c WHERE c.film = :idt ORDER BY c.dateCreation DESC ')
                    ->setParameter('idt', $idt)->getResult();
                break;
            case 'personne':
                $req = $this->getEntityManager()->createQuery('SELECT c FROM MovibeBackendBundle:Commentaire c WHERE c.personne = :idt ORDER BY c.dateCreation DESC ')
                    ->setParameter('idt', $idt)->getResult();
                break;

        }
        return $req;
    }

    public function lastCommentaire()
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT c
            FROM MovibeBackendBundle:Commentaire c
            ORDER BY c.id DESC'

        )
            ->setMaxResults(1)
            ->getSingleResult();
        return $req;
    }
}
