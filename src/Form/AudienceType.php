<?php

namespace App\Form;

use App\Entity\Audience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AudienceType extends AbstractType {

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
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => true,
                    'download_label' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                    'imagine_pattern' => 'scale',
                    'label' => 'Image',
                    'translation_domain' => 'messages'
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Audience::class,
        ]);
    }

}
