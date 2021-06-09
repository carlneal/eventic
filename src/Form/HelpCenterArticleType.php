<?php

namespace App\Form;

use App\Entity\HelpCenterArticle;
use App\Entity\HelpCenterCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Service\AppServices;

class HelpCenterArticleType extends AbstractType {

    private $services;

    public function __construct(AppServices $services) {
        $this->services = $services;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', EntityType::class, [
                    'required' => true,
                    'multiple' => false,
                    'attr' => ['class' => 'select2'],
                    'class' => HelpCenterCategory::class,
                    'choice_label' => 'name',
                    'label' => 'Category',
                    'help' => 'Make sure to select right category to let the users find it quickly',
                    'query_builder' => function() {
                        return $this->services->getHelpCenterCategories(array());
                    },
                ])
                ->add('translations', TranslationsType::class, [
                    'label' => 'Article details',
                    'fields' => [
                        'title' => [
                            'purify_html' => true,
                            'locale_options' => [
                                'en' => ['label' => 'Title'],
                                'fr' => ['label' => 'Titre'],
                                'es' => ['label' => 'Nombre'],
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
                        'tags' => [
                            'purify_html' => true,
                            'field_type' => TextType::class,
                            'attr' => ['class' => 'tags-input'],
                            'locale_options' => [
                                'en' => ['label' => 'Tags'],
                                'fr' => ['label' => 'Mots clés'],
                                'es' => ['label' => 'Palabras clave'],
                                'ar' => ['label' => 'الكلمات الرئيسية'],
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
            'data_class' => HelpCenterArticle::class,
        ]);
    }

}
