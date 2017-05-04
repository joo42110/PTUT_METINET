<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 09/03/2017
 * Time: 16:15
 */

namespace AppBundle\Form;
use AppBundle\Entity\Tournament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options){

        $builder->add('name',TextType::class,array(
           'label' => 'Nom du tournoi',
            'attr' => array(
                'class' => 'form-control'
            ),
        ));

        $builder->add('teamsNumber',NumberType::class,array(
            'label' => "Nombre d'équipes",
            'attr' => array(
                'class' => 'form-control'
            ),
        ));

        $builder->add('poolsNumber',NumberType::class,array(
            'label' => 'Nombre de poules',
            'attr' => array(
                'class' => 'form-control'
            ),
        ));

        $builder->add('teamsOutOfPools',ChoiceType::class,array(
            'label' => 'Sortie de la phase de poules',
            'expanded' => false,
            'multiple' => false,
            'choices'  => array(
                '16ème de finale' => 32,
                '8ème de finale' => 16,
                'Quart de finale' => 8,
                'Demi-finale' => 4,
            ),
            'attr' => array(
                'class' => 'form-control'
            ),
        ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tournament::class,
        ));
    }
}