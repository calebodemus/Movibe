<?php


namespace Movibe\BackendBundle\Twig;



class UtilExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'movibe_backendbundle_twig_util';
    }

    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('age',array($this,'getAge')),
                     new \Twig_SimpleFilter('sexe',array($this,'getSexe'))
        );
    }

    public function getAge($personne)
    {
        $date = new \DateTime('now');
        $dateNaissance = $personne->getDateNaissance();
        $diff = $dateNaissance->diff($date);

        return $diff->format('%Y');
    }

    public function getSexe($personne)
    {
        $sexe = $personne->getSexe();

        switch ($sexe)
        {
            case 0:
                return 'Femme';
                break;
            case 1:
                return 'Homme';
                break;
        }

    }

}

?>