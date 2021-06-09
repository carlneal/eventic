<?php

namespace App\Form;

use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CountryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('translations', TranslationsType::class, [
                    'label' => 'Translation',
                    'fields' => [
                        'name' => [
                            'purify_html' => true,
                            'locale_options' => [
                                'en' => ['label' => 'Name'],
                                'fr' => ['label' => 'Nom'],
                                'es' => ['label' => 'Nombre'],
                                'ar' => ['label' => 'اسم'],
                            ]
                        ]
                    ],
                    'excluded_fields' => ['slug']
                ])
                ->add('code', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Country code'
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Country::class,
        ]);
    }

}
