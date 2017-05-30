<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 29/05/2017
 * Time: 14:01
 */

namespace AppBundle\Form;

use AppBundle\Entity\Day;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayRoundsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('rounds', Collection::class, array(
            'entry_type'   => RoundType::class,
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
            'data_class' => Day::class,
        ));
    }
}