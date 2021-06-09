<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Audience;
use App\Entity\Country;
use App\Form\EventImageType;
use App\Form\EventDateType;
use App\Service\AppServices;

class EventType extends AbstractType {

    private $services;

    public function __construct(AppServices $services) {
        $this->services = $services;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', EntityType::class, [
                    'required' => true,
                    'class' => Category::class,
                    'placeholder' => 'Select an option',
                    'choice_label' => 'name',
                    'label' => 'Category',
                    'help' => 'Make sure to select right category to let the users find it quickly',
                    'query_builder' => function() {
                        return $this->services->getCategories(array());
                    },
                    'attr' => ['class' => 'select2', 'data-sort-options' => '1']
                ])
                ->add('translations', TranslationsType::class, [
                    'label' => 'Event details',
                    'fields' => [
                        'name' => [
                            'purify_html' => true,
                            'help' => "Editing the title after the event is saved won't change the event url",
                            'locale_options' => [
                                'en' => ['label' => 'Name'],
                                'fr' => ['label' => 'Nom'],
                                'es' => ['label' => 'Nombre'],
                                'ar' => ['label' => 'اسم'],
                            ],
                        ],
                        'description' => [
                            'purify_html' => true,
                            'required' => false,
                            'field_type' => TextareaType::class,
                            'attr' => ['class' => 'wysiwyg'],
                            'locale_options' => [
                                'en' => ['label' => 'Description'],
                                'fr' => ['label' => 'Description'],
                                'es' => ['label' => 'Descripción'],
                                'ar' => ['label' => 'التفاصيل'],
                            ]
                        ]
                    ],
                    'excluded_fields' => ['slug']
                ])
                ->add('showattendees', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Attendees',
                    'choices' => ['Hide' => false, 'Show' => true],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'help' => 'Show the attendees number and list in the event page'
                ])
                ->add('enablereviews', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Enable reviews',
                    'choices' => ['Enable' => true, 'Disable' => false],
                    'label_attr' => ['class' => 'radio-custom radio-inline']
                ])
                ->add('languages', EntityType::class, [
                    'required' => false,
                    'multiple' => true,
                    'expanded' => false,
                    'class' => Language::class,
                    'choice_label' => 'name',
                    'label' => 'Languages',
                    'help' => 'Select the languages that will be spoken in your event',
                    'attr' => ['class' => 'select2'],
                    'query_builder' => function() {
                        return $this->services->getLanguages(array());
                    },
                ])
                ->add('subtitles', EntityType::class, [
                    'required' => false,
                    'multiple' => true,
                    'expanded' => false,
                    'class' => Language::class,
                    'choice_label' => 'name',
                    'label' => 'Subtitles',
                    'help' => 'If your event is a movie for example, select the available subtitles',
                    'attr' => ['class' => 'select2'],
                    'query_builder' => function() {
                        return $this->services->getLanguages(array());
                    },
                ])
                ->add('year', ChoiceType::class, [
                    'required' => false,
                    'label' => 'Year',
                    'choices' => $this->getYears(1900),
                    'help' => 'If your event is a movie for example, select the year of release',
                    'attr' => ['class' => 'select2', 'data-sort-options' => '0']
                ])
                ->add('audiences', EntityType::class, [
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,
                    'class' => Audience::class,
                    'choice_label' => 'name',
                    'label' => 'Audiences',
                    'help' => 'Select the audience types that are targeted in your event',
                    'label_attr' => ['class' => 'checkbox-custom checkbox-inline'],
                    'query_builder' => function() {
                        return $this->services->getAudiences(array());
                    },
                ])
                ->add('country', EntityType::class, [
                    'required' => false,
                    'class' => Country::class,
                    'choice_label' => 'name',
                    'label' => 'Country',
                    'help' => "Select the country that your event represents (ie: A movie's country of production)",
                    'query_builder' => function() {
                        return $this->services->getCountries(array());
                    },
                    'attr' => ['class' => 'select2', 'data-sort-options' => '1']
                ])
                ->add('youtubeurl', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Youtube video url',
                    'help' => 'If you have an Youtube video that represents your activities as an event organizer, add it in the standard format: https://www.youtube.com/watch?v=FzG4uDgje3M'
                ])
                ->add('externallink', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'External link',
                    'help' => 'If your event has a dedicated website, enter its url here'
                ])
                ->add('phonenumber', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Contact phone number',
                    'help' => 'Enter the phone number to be called for inquiries'
                ])
                ->add('email', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Contact email address',
                    'help' => 'Enter the email address to be reached for inquiries'
                ])
                ->add('twitter', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Twitter',
                ])
                ->add('instagram', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Instagram',
                ])
                ->add('facebook', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Facebook',
                ])
                ->add('googleplus', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Google plus',
                ])
                ->add('linkedin', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'LinkedIn',
                ])
                ->add('artists', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Artists',
                    'help' => 'Enter the list of artists that will perform in your event (press Enter after each entry)',
                    'attr' => ['class' => 'tags-input']
                ])
                ->add('tags', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Tags',
                    'help' => 'To help attendee find your event quickly, enter some keywords that identify your event (press Enter after each entry)',
                    'attr' => ['class' => 'tags-input']
                ])
                ->add('imageFile', VichImageType::class, [
                    'required' => true,
                    'allow_delete' => false,
                    'download_label' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                    'imagine_pattern' => 'scale',
                    'label' => 'Main event image',
                    'help' => 'Choose the right image to represent your event (We recommend using at least a 1200x600px (2:1 ratio) image )',
                    'translation_domain' => 'messages'
                ])
                ->add('images', CollectionType::class, array(
                    'label' => 'Images gallery',
                    'entry_type' => EventImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'required' => false,
                    'by_reference' => false,
                    'attr' => array(
                        'class' => 'form-collection',
                    ),
                    'help' => 'Add other images that represent your event to be displayed as a gallery',
                    'error_bubbling' => false,
                ))
                ->add('eventdates', CollectionType::class, array(
                    'label' => 'Event dates',
                    'entry_type' => EventDateType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'prototype_name' => '__eventdate__',
                    'required' => true,
                    'by_reference' => false,
                    'error_bubbling' => false,
                    'attr' => array(
                        'class' => 'form-collection eventdates-collection manual-init',
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
            'data_class' => Event::class,
            'validation_groups' => ['create', 'update']
        ]);
    }

    private function getYears($min) {
        $years = range(date('Y', strtotime('+2 years')), $min);
        return array_combine($years, $years);
    }

}
