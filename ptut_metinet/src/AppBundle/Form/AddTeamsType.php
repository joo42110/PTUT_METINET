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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AddTeamsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder->add('teams', CollectionType::class, array(
            'entry_type'   => TeamType::class,
            'prototype_name' => "__index__",
            'entry_options'  => array(
                'label' => false,
                'attr' => array(
                    'class' => 'team-input'
                ),
            ),
            'allow_add' => true,

        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-primary'),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tournament::class,
        ));
    }

}