<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComercioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comRif')
            ->add('comNombEstb')
            ->add('comNumPtte')
            ->add('comNumLic')

            ->add('comCapit')
            /*->add('comFechptteIni')
            ->add('comFechptteFin')*/

            ->add('comTelefFijo')
            ->add('comActEcnma')
            ->add('comPropNac')
            ->add('comPropCedu')
            ->add('comPropNomb')
            ->add('comPropApell')
            ->add('comPropTelefCel')
            ->add('comSadaChk')
            ->add('comSadaCodi')
            ->add('direccion', new ComDireccionType())
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comercio',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_comercio';
    }
}
