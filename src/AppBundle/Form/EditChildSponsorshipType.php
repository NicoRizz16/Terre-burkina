<?php

namespace AppBundle\Form;

use AppBundle\Entity\Child;
use AppBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditChildSponsorshipType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sponsor', EntityType::class, array(
                'class' => 'AppBundle\Entity\User',
                'choice_label' => 'fullName',
                'label' => 'Nom du parrain :',
                'placeholder' => 'Aucun',
                'query_builder' => function(UserRepository $repository){
                    return $repository->getSponsorsQueryBuilder();
                },
                'choice_value' => 'id'
            ))
            ->add('sponsorshipStart', DateType::class, array(
                'label' => 'Début du parrainage'
            ))
            ->add('sponsorshipEnd', DateType::class, array(
                'label' => 'Fin du parrainage'
            ))
            ->add('lastLetterDate', DateType::class, array(
                'label' => 'Date de la dernière lettre'
            ))
            ->add('sponsorshipStatus', ChoiceType::class, array(
                'label' => 'Statut du parrainage',
                'choices' => array(
                    'En attente de parrain' => Child::STATUT_ATTENTE_PARRAIN,
                    'En attente de virement' => Child::STATUT_ATTENTE_VIREMENT,
                    'En attente d\'espace fasoma' => Child::STATUT_ATTENTE_ESPACE_FASOMA,
                    'En cours de parrainage' => Child::STATUT_EN_COURS,
                    'Parrainage urgent' => Child::STATUT_URGENT
                )
            ))
            ->add('sponsorshipType', ChoiceType::class, array(
                'label' => 'Type de parrainage',
                'choices' => array(
                    'Parrainage classique' => Child::PARRAINAGE_CLASSIQUE,
                    'Parrainage autre' => Child::PARRAINAGE_AUTRE,
                    'Parrainage maison de Luc' => Child::PARRAINAGE_MAISON_LUC
                )
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
            ->add('sponsorshipNote', TextareaType::class, array(
                'label' => 'Remarques'
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
