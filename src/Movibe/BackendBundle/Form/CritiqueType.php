<?php

namespace Movibe\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CritiqueType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('presse','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Presse',
                'empty_value' => '',
                'empty_data' => null,
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('note','choice',array(
                'choices' => array(1 => ' ', 2 => ' ', 3 => ' ', 4 => ' ', 5 => ' '),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('commentaire','textarea')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Movibe\BackendBundle\Entity\Critique'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_critique';
    }
}
