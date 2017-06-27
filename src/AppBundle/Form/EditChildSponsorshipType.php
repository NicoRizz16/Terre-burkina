<?php

namespace AppBundle\Form;

use AppBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
