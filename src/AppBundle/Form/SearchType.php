<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('search', \Symfony\Component\Form\Extension\Core\Type\SearchType::class, ['attr' =>
                        ['id' => 'search-navbar-input', "placeholder" => "recherche une observation"]
                ])
                ->add('filter', ChoiceType::class, [
                        'choices' => [
                            'Tous' => 'name',
                            'Espèces' => 'species',
                            'Lieu' => 'place'
                        ],
                        'label' => 'filter',
                        'attr' => ['class' => 'filter-search', 'title' => 'Filtre de recherche']
                ]);
    }
}
