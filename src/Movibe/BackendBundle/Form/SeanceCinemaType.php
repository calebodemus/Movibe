<?php

namespace Movibe\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SeanceCinemaType extends AbstractType
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

        $builder
            ->add('seances','collection',array(
                'type' => new SeanceType($type),
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
            'data_class' => 'Movibe\BackendBundle\Entity\Cinema'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_seances_cinema';
    }
}