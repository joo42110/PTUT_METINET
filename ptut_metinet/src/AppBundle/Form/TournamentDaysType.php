<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 29/05/2017
 * Time: 14:01
 */

namespace AppBundle\Form;

use AppBundle\Entity\Tournament;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentDaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('days', CollectionType::class, array(
            'entry_type'   => DayRoundsType::class,
            'entry_options'  => array(
                'label' => false,
            ),
            'allow_add' => false,
            'allow_delete' => false,

        ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tournament::class,
        ));
    }
}