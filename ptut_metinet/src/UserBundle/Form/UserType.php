<?php
/**
 * Created by PhpStorm.
 * User: Cojecom-Dev
 * Date: 21/02/2017
 * Time: 09:18 AM
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use UserBundle\Entity\User;
use Doctrine\Common\Util\Debug;

class UserRolesType extends AbstractType
{
    private $authorizationChecker;
 
    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        if($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')){

            
            $builder->add('roles', ChoiceType::class, array(
                    'label' => "Niveau d'autorisations",
                    'choices'  => array(
                        'Utilisateur' => 'ROLE_USER',
                        'Arbitre' => 'ROLE_ADMIN',
                        'Administrateur' => 'ROLE_SUPER_ADMIN',
                    ),
                    'multiple' => false,
                    'attr' => array(
                        'class' => 'form-control mail-field'
                    ),
                )
            );
    
            $builder->get('roles')->addModelTransformer(new CallbackTransformer(
                        function ($rolesAsArray){
                            return array_shift($rolesAsArray);
                        },
                        function ($rolesAsString){
                            return(array($rolesAsString));
                        }
                    ))
            ;
        }
    
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            
            $editedUser = $event->getData(); //The user being edited, not the one logged in
            $form = $event->getForm();
            
            $mailLabel = 'Adresse mail';
            $passLabel = 'mot de passe';
            // check if the User is a new one = calling the form in the context of a new user and not editing an existing one
            $isCreationForm = (!$editedUser || null === $editedUser->getId());
            
            if($isCreationForm) {
                $mailLabel .= ' (sera utilisé lors de la connexion)';
                
            }
            else{
                $passLabel = 'nouveau ' . $passLabel;
    
                $form->add(
                    'oldPassword', PasswordType::class, array(
                    'label' => 'Entrez votre ancien mot de passe',
                    'mapped' => false,
                    'required' => false,
                    'attr' => array(
                        'placeholder' => "Ancien mot de passe",
                        'class' => 'form-control mail-field'
                    )
                ));
            }
            
            $form->add(
                'mail', EmailType::class, array(
                'label' => $mailLabel,
                'attr' => array(
                    'placeholder' => $mailLabel,
                    'class' => 'form-control mail-field'
                )
            ));
    
            
            $form->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe renseignés ne correspondent pas.',
                'options' => array(
                    'attr' => array(
                        'class' => 'form-control password-field'
                    )
                ),
                'required' => $isCreationForm, //if the user is editing his profile he does not necessarily want to change his password
                'first_options'  => array(
                    'label' => ucfirst($passLabel),
                    'attr' => array(
                        'placeholder' => ucfirst($passLabel),
                        'class' => 'form-control password-field'
                    ),
                ),
                'second_options' => array(
                    'label' => 'Confirmer le ' . $passLabel,
                    'attr' => array(
                        'placeholder' => "Confirmez le " . $passLabel,
                        'class' => 'form-control password-field'
                    ),
                ),
            ));
            
        });
    
        $builder->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe renseignés ne correspondent pas.',
            'options' => array(
                'attr' => array(
                    'class' => 'form-control password-field'
                )
            ),
            'required' => true,
            'first_options'  => array(
                'label' => 'Mot de passe',
                'attr' => array(
                    'placeholder' => "Mot de passe",
                ),
            ),
            'second_options' => array(
                'label' => 'Confirmer le mot de passe',
                'attr' => array(
                    'placeholder' => "Confirmez le mot de passe",
                ),
            ),
        ));
    
        $builder->add(
            'firstname', TextType::class, array(
            'label' => 'Prenom',
            'attr' => array(
                'placeholder' => "Prénom",
                'class' => 'form-control'
            )
        ));
    
        $builder->add(
            'lastname', TextType::class, array(
            'label' => 'Nom',
            'attr' => array(
                'placeholder' => "Nom",
                'class' => 'form-control'
            )
        ));
    
        $builder->add(
            'phone', TextType::class, array(
            'label' => 'Numéro de téléphone',
            'attr' => array(
                'placeholder' => "Téléphone",
                'class' => 'form-control'
            )
        ));
    
        $builder->add(
            'submit', SubmitType::class, array(
                'label' => 'Valider',
                'attr'  => array(
                    'class' => 'btn btn-primary',
                )
            )
        );
       
        
        
        
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}