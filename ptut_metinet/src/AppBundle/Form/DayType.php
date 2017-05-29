<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 29/05/2017
 * Time: 14:01
 */

namespace AppBundle\Form;

use AppBundle\Entity\Day;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('date', DateType::class, array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'attr' => [
                'class' => 'hidden datepicker-data'
            ]
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Day::class,
        ));
    }
}