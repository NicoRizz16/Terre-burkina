<?php

namespace AppBundle\Form;

use AppBundle\Repository\ChildRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildNewsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('child', EntityType::class, array(
                'class' => 'AppBundle\Entity\Child',
                'choice_label' => 'fullName',
                'label' => 'Choisir un enfant :',
                'query_builder' => function(ChildRepository $repository){
                    return $repository->getChildsListQueryBuilder();
                },
                'choice_value' => 'id'
            ))
            ->add('title', TextType::class, array(
                'label' => 'Titre :'
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Message :',
                'attr' => array(
                    'rows' => '10'
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
            'data_class' => 'AppBundle\Entity\News'
        ));
    }
}
