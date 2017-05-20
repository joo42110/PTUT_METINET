<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 27/03/2017
 * Time: 09:56
 */

namespace AppBundle\Form;


use AppBundle\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FieldType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('name', TextType::class, array(
            'label' => "Intitulé du terrain",
            'attr' => array(
                'class' => 'form-control'
            ),
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Field::class,
        ));
    }

}