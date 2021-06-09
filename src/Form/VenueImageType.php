<?php

namespace App\Form;

use App\Entity\VenueImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class VenueImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('imageFile', VichImageType::class, [
                    'required' => true,
                    'allow_delete' => false,
                    'download_label' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                    'imagine_pattern' => 'scale',
                    'label' => 'Venue image',
                    'translation_domain' => 'messages'
                ])
                ->add('position', HiddenType::class, [
                    'attr' => [
                        'class' => 'form-collection-position',
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => VenueImage::class,
        ]);
    }

}
