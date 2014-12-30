<?php

namespace Movibe\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BoxOfficeDateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function __construct ($type = null)
    {
        $this->type = $type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $this->type;

        $builder
            ->add('boxOffices','collection',array(
                'type' => new BoxOfficeType($type),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Movibe\BackendBundle\Entity\BoxOfficeDate'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_boxOfficesDate';
    }
}