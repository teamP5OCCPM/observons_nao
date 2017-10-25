<?php

namespace AppBundle\Form;

use AppBundle\AppBundle;
use AppBundle\Entity\Bird;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', textType::class, ['label' => 'form_addObservation.title', 'translation_domain' => 'AppBundle'])
                ->add('bird', EntityType::class, [
                        'class' => 'AppBundle:Bird',
                        'label' => 'form_addObservation.bird',
                        'translation_domain' => 'AppBundle'
                ])
                ->add('image', textType::class, ['label' => 'form_addObservation.image', 'translation_domain' => 'AppBundle', 'label_attr' => ['class' => 'mt-3']])
                ->add('description', TextareaType::class, ['label' => 'form_addObservation.description', 'translation_domain' => 'AppBundle'])
                ->add('createdAt', DateType::class, ['label' => 'form_addObservation.createdAt', 'translation_domain' => 'AppBundle'])
                ->add('lng', textType::class, ['label' => 'form_addObservation.lng', 'translation_domain' => 'AppBundle'])
                ->add('lat', textType::class, ['label' => 'form_addObservation.lat', 'translation_domain' => 'AppBundle'])
                ->add('save', SubmitType::class, ['label' => 'form_addObservation.save', 'translation_domain' => 'AppBundle', 'attr' => ['class' => 'btn btn-success']])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_observation';
    }
}
