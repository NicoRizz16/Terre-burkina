<?php

namespace AppBundle\Form;

use AppBundle\Entity\ChildGroup;
use AppBundle\Repository\ChildGroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildAssignGroupType extends AbstractType
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
                'label' => 'Nom du groupe :',
                'query_builder' => function(ChildGroupRepository $repository){
                    return $repository->getGroupsList();
                },
                'choice_value' => 'id'
            ))
        ;
    }

}
