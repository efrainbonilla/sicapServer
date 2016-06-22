<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FactProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prod', 'entity', array(
                'class' => 'AppBundle:Producto',
                'property' => 'prodId',
            ))
            ->add('prestcNum')
            ->add('prestcMed', 'entity', array(
                'class' => 'AppBundle:Medida',
                'property' => 'medId',
            ))
            ->add('fprodCant')
            ->add('med', 'entity', array(
                'class' => 'AppBundle:Medida',
                'property' => 'medId',
            ))
            ->add('fact', 'entity', array(
                'class' => 'AppBundle:Factura',
                'property' => 'factId',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FactProducto',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_factproducto';
    }
}
