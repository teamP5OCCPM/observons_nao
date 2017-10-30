<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('firstName', TextType::class, ['label' => 'Votre prénom*', 'attr' => ['placeholder' => 'Jean']])
                ->add('lastName', TextType::class, ['label' => 'Votre nom*', 'attr' => ['placeholder' => 'Dupont']])
                ->add('email', EmailType::class, ['label' => 'Votre e-mail*', 'attr' => ['placeholder' => 'jeandupont@email.com']])
                ->add('businessName', TextType::class, ['label' => 'Votre raison sociale', 'required' => false])
                ->add('subject', TextType::class, ['label' => 'Sujet*', 'attr' => ['placeholder' => 'Votre sujet...']])
                ->add('message', TextAreaType::class, ['label' => 'Message*', 'attr' => ['rows' => 8, 'placeholder' => 'Votre message...']])
                ->add('send', SubmitType::class, ['label' => 'Envoyer', 'attr' => ['class' => 'btn-primary']]);
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'error_bubbling' => true
        ]);
    }

    public function getName()
    {
        return 'contact_form';
    }
}