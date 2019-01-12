<?php

namespace AppBundle\Form;

use AppBundle\Entity\Child;
use AppBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('dateOfBirth', BirthdayType::class, array(
                'label' => 'Date de naissance'
            ))
            ->add('sex', ChoiceType::class, array(
                'label' => 'Sexe',
                'placeholder' => 'Choisir',
                'choices' => array(
                    'Masculin' => 'M',
                    'Féminin' => 'F'
                )
            ))
            ->add('adress', TextareaType::class, array(
                'label' => 'Adresse complète'
            ))
            ->add('followUpAdress', TextType::class, array(
                'label' => 'Adresse courte (tableau de suivi)'
            ))
            ->add('school', TextType::class, array(
                'label' => 'Ecole'
            ))
            ->add('class', TextType::class, array(
                'label' => 'Classe'
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Téléphone'
            ))
            ->add('familySituation', TextType::class, array(
                'label' => 'Situation familiale'
            ))
            ->add('sponsorshipType', ChoiceType::class, array(
                'label' => 'Type de parrainage',
                'choices' => array(
                    'Parrainage classique' => Child::PARRAINAGE_CLASSIQUE,
                    'Parrainage autre' => Child::PARRAINAGE_AUTRE,
                    'Parrainage maison de Luc' => Child::PARRAINAGE_MAISON_LUC
                )
            ))
            ->add('sponsorshipStart', DateType::class, array(
                'label' => 'Début du parrainage'
            ))
            ->add('sponsorshipEnd', DateType::class, array(
                'label' => 'Fin du parrainage'
            ))
            ->add('coordinator', EntityType::class, array(
                'class' => 'AppBundle\Entity\User',
                'choice_label' => 'username',
                'label' => 'Choix du coordinateur (admin/moderateur)',
                'placeholder' => 'choisir',
                'query_builder' => function(UserRepository $repository){
                    return $repository->getModeratorAndAdminQueryBuilder();
                },
                'choice_value' => 'id'
            ))
            ->add('profilePhoto', FileType::class, array(
                'label' => 'Photo de profil'
            ))
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Child'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_child';
    }


}
