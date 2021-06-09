<?php

namespace App\Form;

use App\Entity\Organizer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrganizerRegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Organizer name'
                    )
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Organizer::class,
        ]);
    }

}
