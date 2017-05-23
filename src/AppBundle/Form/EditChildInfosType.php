<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditChildInfosType extends AbstractType
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
            ->add('adress', TextareaType::class, array(
                'label' => 'Adresse'
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
