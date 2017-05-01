<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CreateUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Nom d\'utilisateur :'
            ))
            ->add('password', TextType::class, array(
                'label' => 'Mot de passe :'
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Adresse e-mail :'
            ))
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'Administrateur' => 'ROLE_ADMIN',
                    'Modérateur' => 'ROLE_MODERATOR',
                    'Coordinateur' => 'ROLE_COORDINATOR',
                    'Parrain' => 'ROLE_SPONSOR'
                ),
                'label' => 'Rôle :'
            ))
            ->add('send_mail', CheckboxType::class, array(
                'label' => 'Envoyer un mail contenant les informations de connexion',
                'required' => false,
                'data' => true
            ))
        ;
    }

}
