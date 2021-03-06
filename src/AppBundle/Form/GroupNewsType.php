<?php

namespace AppBundle\Form;

use AppBundle\Repository\ChildGroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupNewsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('group', EntityType::class, array(
                'class' => 'AppBundle\Entity\ChildGroup',
                'choice_label' => 'name',
                'label' => 'Choisir un groupe d\'enfants :',
                'query_builder' => function(ChildGroupRepository $repository){
                    return $repository->getGroupsList();
                },
                'choice_value' => 'id'
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
