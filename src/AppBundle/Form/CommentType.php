<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class, ['label' => 'Auteur', 'attr' => ['placeholder' => 'Votre nom']])
            ->add('email', EmailType::class, ['label' => 'Email', 'attr' => ['placeholder' => 'Votre Email']])
            ->add('message', TextareaType::class, ['label' => 'Message', 'attr' => ['placeholder' => 'Ecrivez votre message...']])
            ->add('level', HiddenType::class, ['attr' => ['value' => '1']])
            ->add('parentId', HiddenType::class, ['attr' => ['value' => null]])
            ->add('save', SubmitType::class, ['label' => 'Envoyer', 'attr' => ['class' => 'btn btn-secondary text-white']]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Comment'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_comment';
    }
}
