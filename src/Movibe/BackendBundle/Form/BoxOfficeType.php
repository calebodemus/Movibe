<?php

namespace Movibe\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BoxOfficeType extends AbstractType
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
                    ->add('date')
                    ->add('entree')
                ;
                break;
            case 'date':
                $builder
                    ->add('entree')
                    ->add('film','entity',array(
                        'class' => 'Movibe\BackendBundle\Entity\Film',
                        'empty_value' => '',
                        'empty_data' => null,
                        'property' => 'titre',
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
            'data_class' => 'Movibe\BackendBundle\Entity\BoxOffice'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_boxoffice';
    }
}
