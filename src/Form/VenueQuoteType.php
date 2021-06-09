<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class VenueQuoteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', EmailType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Your email',
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 5]),
                    ],
                ])
                ->add('phonenumber', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Phone number',
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 5]),
                    ],
                ])
                ->add('guests', TextType::class, [
                    'required' => false,
                    'label' => 'Number of guests'
                ])
                ->add('note', TextareaType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Additional note'
                ])
                ->add('save', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary btn-block'],
                    'label' => 'Send'
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
        ]);
    }

}
