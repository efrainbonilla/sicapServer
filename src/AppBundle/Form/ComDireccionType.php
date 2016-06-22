<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComDireccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avCalle')
            ->add('ptoRef')
            ->add('com', 'entity', array(
                'class' => 'AppBundle:Comercio',
                'property' => 'comId',
            ))
            ->add('edo', 'entity', array(
                'class' => 'AppBundle:Estado',
                'property' => 'edoCodi',
            ))
            ->add('muni', 'entity', array(
                'class' => 'AppBundle:Municipio',
                'property' => 'muniCodi',
            ))
            ->add('parroq', 'entity', array(
                'class' => 'AppBundle:Parroquia',
                'property' => 'parroqCodi',
            ))
            ->add('zona', 'entity', array(
                'class' => 'AppBundle:Zona',
                'property' => 'zonaId',
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ComDireccion',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_comdireccion';
    }
}
