<?php

namespace Movibe\BackendBundle\Form;

use Movibe\BackendBundle\Entity\MetierRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilmSocieteMetierType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('societe','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Societe',
                'empty_value' => '',
                'empty_data' => null,
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('metier','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Metier',
                'query_builder' => function(MetierRepository $er)
                    {
                        return $er->metierSocietes();
                    },
                'empty_value' => '',
                'empty_data' => null,
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Movibe\BackendBundle\Entity\FilmSocieteMetier'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_filmsocietemetier';
    }
}
