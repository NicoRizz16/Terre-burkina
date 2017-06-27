<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class DonateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', NumberType::class, array(
                'attr' => array(
                    'aria-describedby' => 'basic-addon1',
                    'placeholder' => 'Montant du don'
                ),
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Indiquez un montant'
                    )),
                    new Type(array(
                        'type' => 'numeric',
                        'message' => 'La valeur {{ value }} n\'est pas valide.'
                    )),
                    new GreaterThanOrEqual(array(
                        'value' => 5,
                        'message' => 'Le montant du don doit être au minimum de {{ compared_value }} €'
                    ))
                )
            ))
            ->add('card', SubmitType::class, array(
                'label' => 'Carte',
                'attr' => array(
                    'class' => 'btn btn-ins btn-sm',
                    'formnovalidate' => 'formnovalidate'
                )
            ))
            ->add('cheque', SubmitType::class, array(
                'label' => 'Chèque',
                'attr' => array(
                    'class' => 'btn btn-ins btn-sm',
                    'formnovalidate' => 'formnovalidate'
                )
            ))
            ->add('transfer', SubmitType::class, array(
                'label' => 'Virement',
                'attr' => array(
                    'class' => 'btn btn-ins btn-sm',
                    'formnovalidate' => 'formnovalidate'
                )
            ))
        ;

    }

}
