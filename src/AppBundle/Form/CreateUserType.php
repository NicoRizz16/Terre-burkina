<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateUserType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Nom d\'utilisateur :',
                'required' => true,
                'constraints' => array(
                    new Length(array(
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Le nom d\'utilisateur doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Le nom d\'utilisateur doit faire moins de {{ limit }} caractères'
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer un nom d\'utilisateur'
                    ))
                )
            ))
            ->add('password', TextType::class, array(
                'label' => 'Mot de passe :',
                'required' => true,
                'constraints' => array(
                    new Length(array(
                        'min' => 3,
                        'max' => 30,
                        'minMessage' => 'Le mot de passe doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Le mot de passe doit faire moins de {{ limit }} caractères'
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer un mot de passe'
                    ))
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Adresse e-mail :',
                'constraints' => array(
                    new Email(array(
                        'message' => 'Vous devez entrer une adresse email valide.',
                        'checkMX' => true
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer une adresse email'
                    ))
                )
            ))
            ->add('send_mail', CheckboxType::class, array(
                'label' => 'Envoyer un mail au nouvel utilisateur contenant ses informations de connexion',
                'required' => false,
                'data' => true
            ))
        ;

        // grab the user, do a quick sanity check that one exists
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
                'The CreateUserType cannot be used without an authenticated user!'
            );
        }

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($user) {
                $form = $event->getForm();

                $choices = array(
                    'Modérateur' => 'ROLE_MODERATOR',
                    'Coordinateur' => 'ROLE_COORDINATOR',
                    'Parrain' => 'ROLE_SPONSOR'
                );
                if ($user->hasRole('ROLE_SUPER_ADMIN')){
                    $choices['Administrateur'] = 'ROLE_ADMIN';
                }
                $formOptions = array(
                    'choices' => $choices,
                    'label' => 'Rôle :',
                    'constraints' => array(
                        new Choice(array(
                            'choices' => array(
                                'ROLE_MODERATOR',
                                'ROLE_COORDINATOR',
                                'ROLE_SPONSOR',
                                'ROLE_ADMIN'
                                ),
                            'message' => 'Vous devez choisir un rôle parmi la liste.'
                        ))
                    )
                );

                // create the field, this is similar the $builder->add()
                // field name, field type, data, options
                $form->add('role', ChoiceType::class, $formOptions);
            }
        );
    }

}
