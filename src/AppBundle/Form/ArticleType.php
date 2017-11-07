<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                    'label' => 'Photo de l\'article',
                    'required' => false,
                    'label_attr' => ['class' => 'mt-3'],
                    'download_label' => false,
                    'allow_delete' => false
            ])
            ->add('title', TextType::class, ['label' => 'Titre de l\'article', 'attr' => ['placeholder' => 'Titre de l\'article']])
            ->add('content', TextareaType::class, ['label' => 'Contenu de l\'article', 'attr' => ['placeholder' => 'Ecrivez votre texte...', 'rows' => 10]])
            ->add('isPublished', CheckboxType::class, ['label' => 'Publier ?', 'required' => false])
            ->add('save', SubmitType::class, ['label' => 'Proposer', 'attr' => ['class' => 'btn btn-primary pull-right']]);
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Article'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }
}
