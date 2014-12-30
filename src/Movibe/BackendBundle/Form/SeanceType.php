<?php

namespace Movibe\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SeanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    private $type;

    public function __construct ($type = null)
    {
        $this->type = $type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $this->type;

        switch ($type)
        {
            case 'film':
                $builder
                    ->add('cinema','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\Cinema',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'nom',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                    ->add('typeSeance','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\typeSeance',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'nom',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                    ->add('horaire','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\Horaire',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'affichage',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                ;
                break;
            case 'cinema':
                $builder
                    ->add('film','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\Film',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'titre',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                    ->add('typeSeance','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\typeSeance',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'nom',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                    ->add('horaire','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\Horaire',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'affichage',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                ;
                break;
            default:
                $builder
                    ->add('film','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\Film',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'titre',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                    ->add('cinema','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\Cinema',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'nom',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                    ->add('typeSeance','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\typeSeance',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'nom',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                    ->add('horaire','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\Horaire',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'affichage',
                        'expanded' => false,
                        'multiple' => false,
                    ))
                ;
                break;
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Movibe\BackendBundle\Entity\Seance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_seance';
    }
}
