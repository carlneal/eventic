<?php

namespace App\Form;

use App\Entity\PointOfSale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PointOfSaleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Name',
                ])
                ->add('username', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Username',
                    'constraints' => array(
                        new NotBlank(['groups' => ['create', 'update']]),
                        new Length([
                            'min' => 2,
                            'max' => 15,
                            'groups' => ['create', 'update']
                                ])
                    ),
                ])
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'mapped' => false,
                    'required' => true,
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('purify_html' => true),
                    'first_options' => array('required' => true, 'label' => 'Password', 'constraints' => array(
                            new NotBlank(['groups' => ['create']]),
                            new Length([
                                'min' => 6,
                                'max' => 30,
                                'groups' => ['create', 'update']
                                    ])
                        ),),
                    'second_options' => array('required' => true, 'label' => 'Repeat password'),
                ))
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => PointOfSale::class,
            'validation_groups' => ['create', 'update']
        ]);
    }

}
