<?php

namespace Movibe\BackendBundle\Form;

use Movibe\BackendBundle\Entity\Media;
use Movibe\BackendBundle\Entity\MetierRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class FilmType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('titreOriginal')
            ->add('dateSortie','date',array(
                'widget' => 'single_text'))
            ->add('synopsis','textarea')
            ->add('bandeOriginale')
            ->add('budget')
            ->add('devise','choice',array(
                'choices' => array(0 => '€', 1 => '$' ),
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('anneeProduction')
            ->add('duree')
            ->add('visible','choice',array(
                'choices' => array(0 => 'Non', 1 => 'Oui' ),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('visa')
            ->add('images','collection',array(
                'type' => new ImageType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('couleur','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Couleur',
                'empty_value' => '',
                'empty_data' => null,
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('pays','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Pays',
                'empty_value' => '',
                'empty_data' => null,
                'property' => 'nom',
                'expanded' => false,
                'multiple' => true,
            ))
            ->add('genres','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Genre',
                'empty_value' => '',
                'empty_data' => null,
                'property' => 'nom',
                'expanded' => false,
                'multiple' => true,
            ))
            ->add('langue','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Langue',
                'empty_value' => '',
                'empty_data' => null,
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('typeFilm','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\typeFilm',
                'empty_value' => '',
                'empty_data' => null,
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('critiques','collection',array(
                'type' => new CritiqueType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('medias','collection',array(
                'type' => new MediaType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('acteurs','collection',array(
                'type' => new ActeurType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('realisateurs','collection',array(
                'type' => new RealisateurType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('scenaristes','collection',array(
                'type' => new ScenaristeType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('producteurs','collection',array(
                'type' => new ProducteurType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('equipeTech','collection',array(
                'type' => new EquipeTechType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('distributeurs','collection',array(
                'type' => new DistributeurType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('compositeurs','collection',array(
                'type' => new CompositeurType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('filmSocieteMetiers','collection',array(
                'type' => new FilmSocieteMetierType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Movibe\BackendBundle\Entity\Film'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_film';
    }
}
