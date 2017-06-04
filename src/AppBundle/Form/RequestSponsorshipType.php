<?php

namespace AppBundle\Form;

use AppBundle\Validator\SponsorEmailAvailable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class RequestSponsorshipType extends AbstractType
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
                ),
                'constraints' => array(
                    new Choice(array(
                        'choices' => array(
                            'M.',
                            'Mme.',
                            'Mlle.'
                        ),
                        'message' => 'Vous devez choisir votre civilité parmi la liste.'
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez remplir ce champ'
                    ))
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
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer un prénom'
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
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer un nom'
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
                    )),
                    new SponsorEmailAvailable()
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
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer un numéro de téléphone'
                    ))
                )
            ))
            ->add('address', TextareaType::class, array(
                'label' => 'Adresse',
                'attr' => array(
                    'rows' => 8
                ),
                'constraints' => array(
                    new Length(array(
                        'min' => 3,
                        'max' => 500,
                        'minMessage' => 'L\'adresse doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'L\'adresse doit faire moins de {{ limit }} caractères'
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer une adresse postale'
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
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer une date de naissance'
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
                    )),
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer une fréquence de versement'
                    ))
                )
            ))
            ->add('newsletter', CheckboxType::class, array(
                'label' => 'Recevoir les actualités de l\'association',
                'required' => false,
                'data' => true
            ))
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SponsorshipRequest'
        ));
    }

}
