<?php

namespace Movibe\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BoxOfficeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BoxOfficeRepository extends EntityRepository
{
    public function statByFilm($film = null)
    {
        if (isset($film))
        {
            $tab = $this->ventilationEntreeFilm($film);
            $resultat[$film->getTitre()] = $this->ventilationEnLigne($tab);
        }
        else
        {
            $filmsVisibles = $this->getEntityManager()->createQuery('SELECT f FROM MovibeBackendBundle:Film f WHERE f.visible = true ORDER BY f.titre')
                ->getResult();

            foreach($filmsVisibles as $filmVisible)
            {
                $tab = $this->ventilationEntreeFilm($filmVisible);
                $resultat[$filmVisible->getTitre()] = $this->ventilationEnLigne($tab);
            }
        }
        return $resultat;
    }

    public function ventilationEntreeFilm($film)
    {
        $boxOffices = $film->getBoxOffices();
        $entreeVentiler = array();

        foreach ($boxOffices as $boxOffice)
        {
            $entreeVentiler[$boxOffice->getDateBox()->getDateBoxString()] = $boxOffice->getEntree();
        }

        ksort($entreeVentiler);
        return $entreeVentiler;
    }

    public function ventilationEnLigne($tab)
    {
        $resultat = '';
        foreach($tab as $key => $value)
        {
            if ($value === end($tab))
            {
                $resultat .= $value;
            }
            else
            {
                $resultat .= $value . ',';
            }
        }
        return $resultat;
    }

    public function statByDate($date = null)
    {
        $resultat = "";
        if (isset($date))
        {
            $resultat = $this->ventilationEntreeDate($date);
        }
        else
        {
            $datesVisibles = $this->getEntityManager()->createQuery(
                'SELECT d
             FROM MovibeBackendBundle:BoxOfficeDate d
             WHERE d.dateBox = :date
             GROUP BY d.dateBox
             ORDER BY d.dateBox ASC ')
                ->setParameter('date',$date)
                ->getResult();

            foreach($datesVisibles as $dateVisible)
            {
                $tab = $this->ventilationEntreeDate($dateVisible);
                $resultat[$dateVisible->getTitre()] = $this->ventilationEnLigne($tab);
            }
        }
        return $resultat;
    }

    public function ventilationEntreeDate($date)
    {
        $boxOffices = $date->getBoxOffices();
        $entreesVentiler = array();

        $totalEntrees = 0;
        foreach ($boxOffices as $boxOffice)
        {
            $tab['titre'] = $boxOffice->getFilm()->getTitre();
            $tab['entree'] = $boxOffice->getEntree();
            $tab['percent'] = 0;
            $entreesVentiler[] = $tab;
            $totalEntrees += $boxOffice->getEntree();
            //$entreesVentiler[$boxOffice->getFilm()->getTitre()] = $boxOffice->getEntree();
        }

        foreach ($entreesVentiler as $key => $value)
        {
            $value['percent'] = round($totalEntrees * 100 / $value['entree']);
            $entreesVentiler[$key] = $value;
        }

        return $entreesVentiler;
    }

    public function statByGenre($annee)
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT SUBSTRING(d.dateBox,6,2) mois, g.nom, SUM(b.entree) entree
             FROM MovibeBackendBundle:BoxOffice b
             JOIN b.film f
             JOIN f.genres g
             JOIN b.dateBox d
             WHERE SUBSTRING(d.dateBox,1,4) = :annee
             GROUP BY mois
             ORDER BY mois ASC ')
            ->setParameter('annee', $annee)
            ->getResult();

        return $req;
    }

    public function allGenres($annee)
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT g.nom nom
             FROM MovibeBackendBundle:BoxOffice b
             JOIN b.film f
             JOIN f.genres g
             JOIN b.dateBox d
             WHERE SUBSTRING(d.dateBox,1,4) = :annee
             GROUP BY nom
             ORDER BY nom ASC ')
            ->setParameter('annee', $annee)
            ->getResult();

        return $req;
    }

    public function boxOfficeFilm($dateDebut)
    {
        $req = $this->getEntityManager()->createQuery(
            'SELECT CONCAT(SUBSTRING(d.dateBox,1,4),SUBSTRING(d.dateBox,6,2),SUBSTRING(d.dateBox,9,2)) AS id,f.titre, d.dateBox AS date, b.entree
             FROM MovibeBackendBundle:BoxOffice b
             JOIN b.film f
             JOIN b.dateBox d
             WHERE d.dateBox >= :dateDebut
             ORDER BY f.titre ASC, d.dateBox ASC'
        )
            ->setParameter('dateDebut', $dateDebut)
            ->getResult();

        return $req;
    }

}
