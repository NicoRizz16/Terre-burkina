<?php

namespace AppBundle\Form;

use AppBundle\Entity\ChildGroup;
use AppBundle\Repository\SponsorGroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorAssignGroupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('group', EntityType::class, array(
                'class' => 'AppBundle\Entity\SponsorGroup',
                'choice_label' => 'name',
                'label' => 'Choisir un groupe :',
                'query_builder' => function(SponsorGroupRepository $repository){
                    return $repository->getGroupsList();
                },
                'choice_value' => 'id'
            ))
        ;
    }

}
