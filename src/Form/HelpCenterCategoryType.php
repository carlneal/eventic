<?php

namespace App\Form;

use App\Entity\HelpCenterCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Service\AppServices;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class HelpCenterCategoryType extends AbstractType {

    private $services;

    public function __construct(AppServices $services) {
        $this->services = $services;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                /* ->add('parent', EntityType::class, [
                  'required' => false,
                  'multiple' => false,
                  'class' => HelpCenterCategory::class,
                  'choice_label' => 'name',
                  'attr' => ['class' => 'select2'],
                  'label' => 'Parent',
                  'help' => 'Select the parent category to add a sub category',
                  'query_builder' => function() {
                  return $this->services->getHelpCenterCategories(array("parent" => "none"));
                  }
                  ]) */
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
                ->add('icon', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Icon',
                    'attr' => ['class' => 'icon-picker', 'autocomplete' => 'disabled']
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => HelpCenterCategory::class,
        ]);
    }

}
