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


class AddTeamsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder->add('teams', CollectionType::class, array(
            'entry_type'   => TeamType::class,
            'entry_options'  => array(
            ),
            'allow_add' => true,

        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tournament::class,
        ));
    }

}