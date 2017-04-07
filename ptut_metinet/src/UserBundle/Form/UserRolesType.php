<?php
/**
 * Created by PhpStorm.
 * User: Cojecom-Dev
 * Date: 21/02/2017
 * Time: 09:18 AM
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\User;

class UserType extends AbstractType
{
    private $authorizationChecker;
 
    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $rolesChoice = array(
            'En attente de validation' => 'ROLE_USER',
            'Arbitre' => 'ROLE_REFEREE',
        );

        if($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            $rolesChoice['Administrateur'] = 'ROLE_ADMIN';
        }



        $builder->add('roles', ChoiceType::class, array(
            'label' => "Niveau d'autorisations",
            'choices'  => $rolesChoice,
            'multiple' => false,
            'attr' => array(
                'class' => 'form-control mail-field'
            ),
        ));

        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
                    function ($rolesAsArray){
                        return array_shift($rolesAsArray);
                    },
                    function ($rolesAsString){
                        return(array($rolesAsString));
                    }
        ));
        
        
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}