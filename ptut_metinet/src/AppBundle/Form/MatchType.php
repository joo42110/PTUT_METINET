<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 29/05/2017
 * Time: 14:01
 */

namespace AppBundle\Form;

use AppBundle\Entity\Day;
use AppBundle\Entity\Field;
use AppBundle\Entity\Match;
use AppBundle\Entity\Round;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use UserBundle\Entity\User;

class MatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $match = $event->getData();
            $form = $event->getForm();

            $form->add('day', EntityType::class, array(
                'label' => false,
                'class' => Day::class,
                'choice_label' => 'stringDate',
                'mapped' => false,
                'choices' => $match->getTournament()->getDays(),
                'attr' => array(
                    'class' => 'form-control'
                )

            ));

            $tournamentRounds = [];
            foreach($match->getTournament()->getDays() as $day){ //On génère une liste de tout les créneaux horaires de ce tournoi
                $tournamentRounds = array_merge($tournamentRounds,$day->getRounds()->toArray());
            }


            $form->add('round', EntityType::class, array(
                'label' => false,
                'class' => Round::class,
                'choice_label' => 'scheduledTime',
                'choices' => $tournamentRounds,
                'attr' => array(
                    'class' => 'form-control'
                )

            ));

            $form->add('field', EntityType::class, array(
                'label' => false,
                'class' => Field::class,
                'choice_label' => 'name',
                'choices' => $match->getTournament()->getFields(),
                'attr' => array(
                    'class' => 'form-control'
                )

            ));
        });

        $builder->add('referee', EntityType::class, array(
            'label' => false,
            'class' => User::class,
            'choice_label' => 'printableName',
            'attr' => array(
                'class' => 'form-control'
            )

        ));





    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Match::class,
        ));
    }
}