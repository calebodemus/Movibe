<?php

namespace Movibe\BackendBundle\Form;

use Movibe\BackendBundle\Entity\ImageRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    protected $type;
    protected $idt;

    public function __construct ($type, $idt)
    {
        $this->type = $type;
        $this->idt = $idt;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $this->type;
        $idt = $this->idt;

        $builder
            ->add('titre')
            ->add('description','textarea')
            ->add('image','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Image',
                'query_builder' => function(ImageRepository $er) use ($type,$idt)
                    {
                        return $er->newsImage($type,$idt);
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
            'data_class' => 'Movibe\BackendBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'movibe_backendbundle_news';
    }
}
