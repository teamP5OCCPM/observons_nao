<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('search', \Symfony\Component\Form\Extension\Core\Type\SearchType::class, ['attr' =>
                        ['id' => 'search-navbar-input', 'class' => 'typeahead', "placeholder" => "recherche une observation"]
                ])
                ->add('send', SubmitType::class, ['label' => 'Rechercher', 'attr' => ['class' => 'btn-nao-green']]);
    }
}
