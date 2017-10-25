<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'form.firstname', 'translation_domain' => 'FOSUserBundle'])
            ->add('lastName', TextType::class, ['label' => 'form.lastname', 'translation_domain' => 'FOSUserBundle'])
            ->add('newsletter', CheckboxType::class, ['label' => 'form.newsletter', 'required' => false, 'translation_domain' => 'FOSUserBundle']);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }


    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }


    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
