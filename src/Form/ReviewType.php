<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReviewType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('rating', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Your rating (out of 5 stars)',
                    'choices' => ['5 stars' => 5, '4 stars' => 4, '3 stars' => 3, '2 stars' => 2, '1 star' => 1],
                    'label_attr' => ['class' => 'radio-custom radio-inline']
                ])
                ->add('headline', TextType::class, [
                    'purify_html' => true,
                    'label' => 'Your review headline',
                ])
                ->add('details', TextareaType::class, [
                    'purify_html' => true,
                    'label' => 'Let the other attendee know more details about your experience',
                    'attr' => ['rows' => 10]
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }

}
