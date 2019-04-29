<?php

namespace App\Form;

use App\Entity\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('level', ChoiceType::class, ['choices'  => [
                                                                    'Aucun filtre' => 'rien',
                                                                    '6eme' => '6eme',
                                                                    '5eme' => '5eme',
                                                                    '4eme' => '4eme',
                                                                    '3eme' => '3eme',
                                                                    '2nde' => '2nde',
                                                                    '1re' => '1re',
                                                                    'Terminale' => 'Terminale',
                                                                    'L1' => 'L1',
                                                                    'L2' => 'L2',
                                                                    'L3' => 'L3'
                                                                ], 'label' => 'Pour quel niveau ?'])
               ->add('subject', ChoiceType::class, ['choices'  => [
                                                                    'Aucun filtre' => NULL,
                                                                    'Mathématiques' => 'maths',
                                                                    'Physique' => 'physique',
                                                                    'SVT' => 'svt',
                                                                    'Anglais' => 'anglais',
                                                                    'Histoire et Geographique' => 'histoire',
                                                                    'Espagnol' => 'espagnol',
                                                                    'Français' => 'francais',
                                                                ], 'label' => 'Pour quelle matière ?'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
