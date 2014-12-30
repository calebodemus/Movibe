<?php

namespace Movibe\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CinemaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('ville','hidden',array(
                'data_class' => 'Movibe\BackendBundle\Entity\Ville',
            ))
            ->add('region','entity',array(
                'class' => 'MovibeBackendBundle:Region',
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'mapped'   => false,
                'empty_value' => '',
            ))
            ->add('departement','choice',array(
                'expanded' => false,
                'multiple' => false,
                'mapped'   => false,
            ))
            ->add('city','choice',array(
                'expanded' => false,
                'multiple' => false,
                'mapped'   => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Movibe\BackendBundle\Entity\Cinema'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_cinema';
    }
}
