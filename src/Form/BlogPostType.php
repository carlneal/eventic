<?php

namespace App\Form;

use App\Entity\BlogPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\BlogPostCategory;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Service\AppServices;

class BlogPostType extends AbstractType {

    private $services;

    public function __construct(AppServices $services) {
        $this->services = $services;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('category', EntityType::class, [
                    'required' => true,
                    'class' => BlogPostCategory::class,
                    'choice_label' => 'name',
                    'label' => 'Category',
                    'help' => 'Make sure to select right category to let the users find it quickly',
                    'query_builder' => function() {
                        return $this->services->getBlogPostCategories(array());
                    },
                ])
                ->add('translations', TranslationsType::class, [
                    'label' => 'Event details',
                    'fields' => [
                        'name' => [
                            'purify_html' => true,
                            'locale_options' => [
                                'en' => ['label' => 'Name'],
                                'fr' => ['label' => 'Nom'],
                                'es' => ['label' => 'Nombre'],
                                'ar' => ['label' => 'اسم'],
                            ]
                        ],
                        'content' => [
                            'purify_html' => true,
                            'field_type' => TextareaType::class,
                            'attr' => ['class' => 'wysiwyg'],
                            'locale_options' => [
                                'en' => ['label' => 'Description'],
                                'fr' => ['label' => 'Description'],
                                'es' => ['label' => 'Descripción'],
                                'ar' => ['label' => 'التفاصيل'],
                            ]
                        ],
                        'tags' => [
                            'purify_html' => true,
                            'field_type' => TextType::class,
                            'help' => 'To help attendee find your event quickly, enter some keywords that identify your event (press Enter after each entry)',
                            'attr' => ['class' => 'tags-input'],
                            'locale_options' => [
                                'en' => ['label' => 'Tags'],
                                'fr' => ['label' => 'Mots clés'],
                                'es' => ['label' => 'Palabras clave'],
                                'ar' => ['label' => 'العلامات'],
                            ]
                        ]
                    ],
                    'excluded_fields' => ['slug'],
                ])
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => true,
                    'download_label' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                    'imagine_pattern' => 'scale',
                    'label' => 'Main blog post image',
                    'translation_domain' => 'messages'
                ])
                ->add('readtime', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Read time in minutes',
                    'attr' => ['class' => 'touchspin-integer', 'data-min' => 1, "data-max" => 1000000]
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => BlogPost::class,
        ]);
    }

}
