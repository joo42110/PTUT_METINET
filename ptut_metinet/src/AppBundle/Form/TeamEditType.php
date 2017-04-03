<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 03/04/2017
 * Time: 09:05
 */

namespace AppBundle\Form;

use AppBundle\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TeamEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('players', CollectionType::class, array(
            'entry_type'   => PlayerType::class,
            'prototype_name' => "__index__",
            'entry_options'  => array(
                'label' => false,
                'attr' => array(
                    'class' => 'team-input'
                ),
            ),
            'allow_add' => true,
            'allow_delete' => true,

        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-primary'),
        ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Team::class,
        ));
    }

}