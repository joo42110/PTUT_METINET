<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 27/03/2017
 * Time: 09:56
 */

namespace AppBundle\Form;


use AppBundle\Entity\Team;
use AppBundle\Form\DataTransformer\CsvToPlayersTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TeamType extends AbstractType
{

    private $player_loader;
    private $file_uploader;

    /**
     * TeamType constructor.
     * @param $player_loader
     * @param $file_uploader
     */
    public function __construct($player_loader, $file_uploader)
    {
        $this->player_loader = $player_loader;
        $this->file_uploader = $file_uploader;
    }


    public function buildForm(FormBuilderInterface $builder,array $options)
    {

        $builder->add('name', TextType::class, array(
            'label' => "Nom de l'équipe",
            'attr' => array(
                'class' => 'form-control'
            ),
        ));


        $builder->add('players', FileType::class, array(
            'label' => "Joueurs",
            'attr' => array(
                'class' => 'form-control'
            ),
        ));

        $builder->get('players')->addModelTransformer(new CsvToPlayersTransformer($this->player_loader,$this->file_uploader));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Team::class,
        ));
    }

}