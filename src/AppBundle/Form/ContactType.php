<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 11/05/2017
 * Time: 21:43
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, array(
                'label' => 'Civilité',
                'choices' => array(
                    'M.' => 'M.',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle',
                    'Entreprise' => 'Entreprise',
                    'Association' => 'Association'
                ),
                'constraints' => array(
                    new Choice(array(
                        'choices' => array(
                            'M.',
                            'Mme.',
                            'Mlle.',
                            'Entreprise',
                            'Association'
                        ),
                        'message' => 'Vous devez choisir votre civilité parmi la liste.'
                    ))
                )
            ))
            ->add('name', TextType::class, array(
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
            ->add('knowUs', TextType::class, array(
                'label' => 'Manière dont vous nous avez connu',
                'constraints' => array(
                    new Length(array(
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Ce champ doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Ce champ doit faire moins de {{ limit }} caractères'
                    ))
                )
            ))
            ->add('object', TextType::class, array(
                'label' => 'Objet',
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer un objet'
                    )),
                    new Length(array(
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Ce champ doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Ce champ doit faire moins de {{ limit }} caractères'
                    ))
                )
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Votre message',
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Vous devez indiquer un message'
                    )),
                    new Length(array(
                        'min' => 10,
                        'max' => 10000,
                        'minMessage' => 'Votre message doit faire plus de {{ limit }} caractères',
                        'maxMessage' => 'Votre message doit faire moins de {{ limit }} caractères'
                    ))
                )
            ))
            ->add('newsletter', CheckboxType::class, array(
                'label'    => 'Recevoir les actualités de l\'association sur mon adresse email',
                'required' => false,
                'data' => true
            ))
            ;
    }
}