<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 29/05/2017
 * Time: 14:01
 */

namespace AppBundle\Form;

use AppBundle\Entity\Match;
use AppBundle\Entity\Round;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('round', EntityType::class, array(
            'class' => Round::class,
            'choice_label' => 'scheduledTime',

        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Match::class,
        ));
    }
}