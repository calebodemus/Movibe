<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RechercheRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SearchRepository extends EntityRepository
{
    public function search($search)
    {
        switch ($search->getCategorie())
        {
            case 'all':
                $this->searchFilms($search);
                $this->searchPersonnes($search);
                $this->searchCinemas($search);
                break;
            case 'globale':
                $this->searchFilms($search);
                $this->searchPersonnes($search);
                break;
            case  'Film/Cinema':
                $this->searchFilms($search);
                $this->searchCinemas($search);
                break;
            case 'film':
                $this->searchFilms($search);
                break;
            case 'personne':
                $this->searchPersonnes($search);
                break;
            case 'cinema':
                $this->searchCinemas($search);
                break;
            case 'user':
                break;
        }
    }

    public function searchFilms($search)
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT f
             FROM MovibeBackendBundle:Film f
             WHERE f.titre LIKE :recherche'
        )
            ->setParameter('recherche','%' . $search->getRecherche() . '%')
            ->getResult();

        foreach ($req as $film)
        {
            $film->searchPromotion();
        }

        $search->setResultat($req,'films');
    }

    public function searchPersonnes($search)
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT p
             FROM MovibeBackendBundle:Personne p
             WHERE p.nom LIKE :recherche
             OR p.prenom LIKE :recherche'
        )
            ->setParameter('recherche','%' . $search->getRecherche() . '%')
            ->getResult();

        foreach ($req as $personne)
        {
            $personne->searchPromotion();
        }

        $search->setResultat($req,'personnes');
    }

    public function searchCinemas($search)
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT c
             FROM MovibeBackendBundle:Cinema c
             WHERE c.nom LIKE :recherche'
        )
            ->setParameter('recherche','%' . $search->getRecherche() . '%')
            ->getResult();

        $search->setResultat($req,'cinemas');
    }

    public function formatJson($resultat)
    {
        $result = array();

        foreach ($resultat as $key => $value)
        {
            $i=0;
            switch ($key)
            {
                case 'films':
                    while (isset($value[$i]))
                    {
                        $film =  $value[$i];
                        $film->searchPromotion();
                        $value[$i] = $film->to_json();
                        $result[] = $value[$i];
                        $i++;
                    }
                    $resultat['films'] = $value;
                    break;

                case 'personnes':
                    while (isset($value[$i]))
                    {
                        $personne =  $value[$i];
                        $personne->searchPromotion();
                        $value[$i] = $personne->to_json();
                        $result[] = $value[$i];
                        $i++;
                    }
                    $resultat['personnes'] = $value;
                    break;

                case 'cinemas':
                    while (isset($value[$i]))
                    {
                        $cinema =  $value[$i];
                        $value[$i] = $cinema->to_json();
                        $result[] = $value[$i];
                        $i++;
                    }
                    $resultat['cinemas'] = $value;
                    break;
                case 'users':
                    break;
            }
        }
        return $result;
    }
}
