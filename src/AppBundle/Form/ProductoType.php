<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prodNomb')
            ->add('cat', 'entity', array(
                'class' => 'AppBundle:Categoria',
                'property' => 'catId',
            ))
            ->add('grup', 'entity', array(
                'class' => 'AppBundle:Grupo',
                'property' => 'grupId',
            ))
            ->add('sgrup', 'entity', array(
                'class' => 'AppBundle:Sgrupo',
                'property' => 'sgrupId',
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Producto',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_producto';
    }
}
