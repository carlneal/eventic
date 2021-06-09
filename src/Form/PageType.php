<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('translations', TranslationsType::class, [
                    'required' => true,
                    'label' => 'Page content',
                    'fields' => [
                        'title' => [
                            'purify_html' => true,
                            'locale_options' => [
                                'en' => ['label' => 'Title'],
                                'fr' => ['label' => 'Titre'],
                                'es' => ['label' => 'Título'],
                                'ar' => ['label' => 'عنوان'],
                            ]
                        ],
                        'content' => [
                            'purify_html' => true,
                            'field_type' => TextareaType::class,
                            'attr' => ['class' => 'wysiwyg'],
                            'locale_options' => [
                                'en' => ['label' => 'Content'],
                                'fr' => ['label' => 'Contenu'],
                                'es' => ['label' => 'Contenido'],
                                'ar' => ['label' => 'محتوى'],
                            ]
                        ],
                    ],
                    'excluded_fields' => ['slug']
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }

}
