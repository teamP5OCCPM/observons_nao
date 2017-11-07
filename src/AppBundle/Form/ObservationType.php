<?php

namespace AppBundle\Form;

use AppBundle\Entity\Bird;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, ['label' => 'Nom de l\'observation'])
            ->add('bird', EntityType::class, [
                    'class' => 'AppBundle:Bird',
                    'label' => 'Espèce'
            ])
            ->add('imageFile', VichImageType::class, [
                    'label' => 'Photo de l\'oiseau', 'required' => false,
                    'label_attr' => ['class' => 'mt-3'],
                    'download_label' => false,
                    'allow_delete' => false
            ])
            ->add('description', TextareaType::class, ['label' => 'Description de l\'observation', 'attr' => ['rows' => 8]])
            ->add('observedAt', DateType::class, ['label' => 'Date de l\'observation'])
            ->add('lng', TextType::class, ['label' => 'Longitude', 'attr' => ['class' => 'loc-input']])
            ->add('lat', TextType::class, ['label' => 'Latitude', 'attr' => ['class' => 'loc-input']])
            ->add('city', HiddenType::class, ['attr' => ['class' => 'city-input']])
            ->add('save', SubmitType::class, ['label' => 'Envoyer', 'attr' => ['class' => 'btn btn-nao-green']]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'AppBundle\Entity\Observation'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_observation';
    }
}
