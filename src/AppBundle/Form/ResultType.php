<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', IntegerType::class, array(
                'label' => 'Année scolaire (à la rentrée) :'
            ))
            ->add('average1', TextType::class, array(
                'label' => 'Moyenne 1er trimèstre (/ 20) :'
            ))
            ->add('rank1', TextType::class, array(
                'label' => 'Rang 1er trimèstre :'
            ))
            ->add('average2', TextType::class, array(
                'label' => 'Moyenne 2ème trimèstre  (/ 20):'
            ))
            ->add('rank2', TextType::class, array(
                'label' => 'Rang 2ème trimèstre :'
            ))
            ->add('average3', TextType::class, array(
                'label' => 'Moyenne 3ème trimèstre (/ 20) :'
            ))
            ->add('rank3', TextType::class, array(
                'label' => 'Rang 3ème trimèstre :'
            ))
            ->add('averageYear', TextType::class, array(
                'label' => 'Moyenne sur l\'année (/ 20) :'
            ))
            ->add('rankYear', TextType::class, array(
                'label' => 'Rang sur l\'année :'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Result'
        ));
    }

}
