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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        


        $builder->add('submit',SubmitType::class,array(
            'attr' => array(
                'class' => 'btn btn-primary'
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