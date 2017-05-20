<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 27/03/2017
 * Time: 11:07
 */

namespace AppBundle\Form;

use AppBundle\Entity\Tournament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddFieldsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('fields', CollectionType::class, array(
            'entry_type'   => FieldType::class,
            'prototype_name' => "__index__",
            'entry_options'  => array(
                'label' => false,
            ),
            'allow_add' => true,
            'allow_delete' => true,

        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tournament::class,
        ));
    }

}