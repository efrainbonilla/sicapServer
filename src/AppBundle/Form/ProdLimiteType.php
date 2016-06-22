<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProdLimiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prodlCant')
            ->add('prodlStatus', 'text', array('data' => '', 'empty_data' => '-'))
            ->add('prodlRuta', 'text', array('data' => '', 'empty_data' => '-'))
            ->add('prod', 'entity', array(
                'class' => 'AppBundle:Producto',
                'property' => 'prodId',
            ))
            ->add('med', 'entity', array(
                'class' => 'AppBundle:Medida',
                'property' => 'medId',
            ))
            ->add('com', 'entity', array(
                'class' => 'AppBundle:Comercio',
                'property' => 'comId',
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ProdLimite',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_prodlimite';
    }
}
