<?php

namespace Movibe\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url','textarea')
            ->add('poids','choice',array(
                'choices' => array(0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5 ),
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('descriptif','textarea')
            ->add('type','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\TypeMedia',
                'property' => 'libelle',
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
            'data_class' => 'Movibe\BackendBundle\Entity\Media'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_media';
    }
}
