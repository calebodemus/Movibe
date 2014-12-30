<?php

namespace Movibe\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonneType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('dateNaissance','date',array(
                'widget' => 'single_text'))
            ->add('pseudos','collection',array(
                'type' => 'text',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'options'  => array(
                    'required'  => false,
                    'attr'      => array('class' => 'pseudo')
                ),
            ))
            ->add('biographie','textarea')
            ->add('sexe','choice',array(
                'choices' => array(0 => 'Femme', 1 => 'Homme' ),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('villeNaissance','hidden',array(
                'data_class' => 'Movibe\BackendBundle\Entity\Ville',
            ))
            ->add('paysNaissance','entity',array(
                'class' => 'MovibeBackendBundle:Pays',
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'mapped'   => false,
                'empty_value' => '',
            ))
            ->add('regionNaissance','choice',array(
                'expanded' => false,
                'multiple' => false,
                'mapped'   => false,
            ))
            ->add('departementNaissance','choice',array(
                'expanded' => false,
                'multiple' => false,
                'mapped'   => false,
            ))
            ->add('cityNaissance','choice',array(
                'expanded' => false,
                'multiple' => false,
                'mapped'   => false,
            ))
            ->add('nationalite','entity',array(
                'class' => 'MovibeBackendBundle:Pays',
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'empty_value' => '',
            ))
            ->add('images','collection',array(
                'type' => new ImageType(),
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
            'data_class' => 'Movibe\BackendBundle\Entity\Personne'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_personne';
    }
}
