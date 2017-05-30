<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 27/03/2017
 * Time: 09:56
 */

namespace AppBundle\Form;


use AppBundle\Entity\Field;
use AppBundle\Entity\Round;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RoundType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('scheduledTime', TextType::class, array(
            'label' => "Horaire du créneau",
            'attr' => array(
                'class' => 'form-control'
            ),
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Round::class,
        ));
    }

}