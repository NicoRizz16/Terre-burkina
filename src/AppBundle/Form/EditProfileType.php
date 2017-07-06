<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditProfileType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, array(
                'label' => 'Civilité',
                'choices' => array(
                    'M.' => 'M.',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                )
            ))
            ->add('firstName', TextType::class, array(
                'label' => 'Prénom',
                'constraints' => array(
                    new Length(array(
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le prénom doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Le prénom doit faire moins de {{ limit }} caractères'
                    ))
                )
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Nom',
                'constraints' => array(
                    new Length(array(
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le nom doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Le nom doit faire moins de {{ limit }} caractères'
                    ))
                )
            ))
            ->add('dateOfBirth', BirthdayType::class, array(
                'label' => 'Date de naissance',
                'constraints' => array(
                    new Date(array(
                        'message' => 'Vous devez entrer une date.'
                    )),
                    new LessThan(array(
                        'value' => 'today',
                        'message' => 'La date de naissance doit être antérieure à la date actuelle.'
                    ))
                )
            ))
            ->add('adress', TextareaType::class, array(
                'label' => 'Adresse',
                'constraints' => array(
                    new Length(array(
                        'min' => 3,
                        'max' => 500,
                        'minMessage' => 'L\'adresse doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'L\'adresse doit faire moins de {{ limit }} caractères'
                    ))
                )
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Téléphone',
                'constraints' => array(
                    new Length(array(
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le numéro de téléphone doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Le numéro de téléphone doit faire moins de {{ limit }} caractères'
                    ))
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Adresse e-mail',
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
            ->add('paymentChoice', ChoiceType::class, array(
                'label' => 'Versement',
                'choices' => array(
                    'Menusel' => 'mensuel',
                    'Trimestriel' => 'trimestriel',
                    'Semestriel' => 'semestriel',
                    'Annuel' => 'annuel'
                ),
                'constraints' => array(
                    new Choice(array(
                        'choices' => array(
                            'mensuel',
                            'trimestriel',
                            'semestriel',
                            'annuel'
                        ),
                        'message' => 'Vous devez choisir un versement parmi la liste.'
                    ))
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'first_options'  => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmation'),
                'constraints' => array(
                    new Length(array(
                        'min' => 3,
                        'max' => 30,
                        'minMessage' => 'Le mot de passe doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Le mot de passe doit faire moins de {{ limit }} caractères'
                    ))
                )
            ))
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

}
