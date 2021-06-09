<?php

namespace App\Form;

use App\Entity\MenuElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Service\AppServices;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MenuElementType extends AbstractType {

    private $services;

    public function __construct(AppServices $services) {
        $this->services = $services;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('icon', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Icon',
                    'attr' => ['class' => 'icon-picker', 'autocomplete' => 'disabled']
                ])
                ->add('translations', TranslationsType::class, [
                    'label' => 'Translation',
                    'fields' => [
                        'label' => [
                            'purify_html' => true,
                            'locale_options' => [
                                'en' => ['label' => 'Link text'],
                                'fr' => ['label' => 'Texte du lien'],
                                'es' => ['label' => 'Texto del enlace'],
                                'ar' => ['label' => 'نص الرابط'],
                            ]
                        ]
                    ],
                    'excluded_fields' => ['slug']
                ])
                ->add('link', ChoiceType::class, [
                    'required' => false,
                    'label' => 'Choose the link destination page',
                    'choices' => $this->services->getLinks(),
                    'attr' => ['class' => 'select2', 'data-sort-options' => '0']
                ])
                ->add('customLink', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Custom link',
                ])
                ->add('position', HiddenType::class, [
                    'attr' => [
                        'class' => 'menuelement-position',
        ]]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => MenuElement::class,
        ]);
    }

}
