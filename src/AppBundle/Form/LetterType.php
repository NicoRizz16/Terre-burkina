<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LetterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creationDate', DateType::class, array(
                'label' => 'Date :'
            ))
            ->add('summary', TextareaType::class, array(
                'label' => 'Sommaire :'
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenu de la lettre :'
            ))
            ->add('module1Content', TextareaType::class, array(
                'label' => 'Contenu module 1 :'
            ))
            ->add('module1Photo', FileType::class, array(
                'required' => false,
                'label' => 'Image module 1 :'
            ))
            ->add('module2Content', TextareaType::class, array(
                'label' => 'Contenu module 2 :'
            ))
            ->add('module2Photo', FileType::class, array(
                'required' => false,
                'label' => 'Image module 2 :'
            ))
            ->add('module3Content', TextareaType::class, array(
                'label' => 'Contenu module 3 :'
            ))
            ->add('module3Photo', FileType::class, array(
                'required' => false,
                'label' => 'Image module 3 :'
            ))
            ->add('module4Content', TextareaType::class, array(
                'label' => 'Contenu module 4 :'
            ))
            ->add('module4Photo', FileType::class, array(
                'required' => false,
                'label' => 'Image module 4 :'
            ))
            ->add('module5Content', TextareaType::class, array(
                'label' => 'Contenu module 5 :'
            ))
            ->add('module5Photo', FileType::class, array(
                'required' => false,
                'label' => 'Image module 5 :'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Letter'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_letter';
    }


}
