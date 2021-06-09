<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\MenuElementType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MenuType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('translations', TranslationsType::class, [
                    'required' => false,
                    'label' => 'Translation',
                    'fields' => [
                        'name' => [
                            'purify_html' => true,
                            'locale_options' => [
                                'en' => ['label' => 'Menu name'],
                                'fr' => ['label' => 'Nom du menu'],
                                'es' => ['label' => 'Nombre du menú'],
                                'ar' => ['label' => 'اسم القائمة'],
                            ]
                        ],
                        'header' => [
                            'purify_html' => true,
                            'locale_options' => [
                                'en' => ['label' => 'Header text'],
                                'fr' => ['label' => 'En-tête'],
                                'es' => ['label' => 'En cabeza'],
                                'ar' => ['label' => 'نص العنوان'],
                            ]
                        ]
                    ],
                    'excluded_fields' => ['slug']
                ])
                ->add('menuElements', CollectionType::class, array(
                    'label' => 'Menu elements',
                    'entry_type' => MenuElementType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'prototype_name' => '__menuelements__',
                    'required' => true,
                    'by_reference' => false,
                    'attr' => array(
                        'class' => 'menuelements-collection form-collection manual-init',
                    ),
                ))
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }

}
