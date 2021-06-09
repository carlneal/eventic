<?php

namespace App\Form;

use App\Entity\Venue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Country;
use App\Entity\VenueType as Type;
use App\Form\VenueImageType;
use App\Entity\Amenity;
use App\Service\AppServices;

class VenueType extends AbstractType {

    private $services;

    public function __construct(AppServices $services) {
        $this->services = $services;
    }

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
                        ],
                        'description' => [
                            'purify_html' => true,
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
                ->add('type', EntityType::class, [
                    'required' => true,
                    'class' => Type::class,
                    'choice_label' => 'name',
                    'label' => 'Type',
                    'query_builder' => function() {
                        return $this->services->getVenuesTypes(array());
                    }
                ])
                ->add('amenities', EntityType::class, [
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                    'class' => Amenity::class,
                    'choice_label' => 'name',
                    'label' => 'Amenities',
                    'label_attr' => ['class' => 'checkbox-custom checkbox-inline'],
                    'query_builder' => function() {
                        return $this->services->getAmenities(array());
                    }
                ])
                ->add('seatedguests', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Seated guests number',
                    'attr' => ['class' => 'touchspin-integer', 'data-max' => 100000]
                ])
                ->add('standingguests', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Standing guests number',
                    'attr' => ['class' => 'touchspin-integer', 'data-max' => 100000]
                ])
                ->add('neighborhoods', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Neighborhoods',
                ])
                ->add('foodbeverage', TextareaType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Food and beverage details',
                ])
                ->add('pricing', TextareaType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Pricing',
                ])
                ->add('availibility', TextareaType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Availibility',
                ])
                ->add('street', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Street address',
                ])
                ->add('street2', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Street address 2',
                ])
                ->add('city', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'City',
                ])
                ->add('postalcode', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Zip / Postal code',
                ])
                ->add('state', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'State',
                ])
                ->add('country', EntityType::class, [
                    'required' => true,
                    'class' => Country::class,
                    'choice_label' => 'name',
                    'label' => 'Country',
                    'attr' => ['class' => 'select2'],
                    'placeholder' => 'Select an option',
                    'query_builder' => function() {
                        return $this->services->getCountries(array());
                    }
                ])
                ->add('lat', HiddenType::class, [
                    'required' => false,
                ])
                ->add('lng', HiddenType::class, [
                    'required' => false,
                ])
                ->add('showmap', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show the map along with the address on the venue page and event page',
                    'choices' => ['No' => false, 'Yes' => true],
                    'label_attr' => ['class' => 'radio-custom radio-inline']
                ])
                ->add('quoteform', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show the quote form on the venue page',
                    'choices' => ['No' => false, 'Yes' => true],
                    'label_attr' => ['class' => 'radio-custom radio-inline']
                ])
                ->add('contactemail', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Contact email',
                    'help' => 'This email address will be used to receive the quote requests, make sure to mention it if you want to show the quote form'
                ])
                ->add('images', CollectionType::class, array(
                    'required' => false,
                    'label' => 'Images',
                    'entry_type' => VenueImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    'attr' => array(
                        'class' => 'form-collection',
                    ),
                ))
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Venue::class,
        ]);
    }

}
