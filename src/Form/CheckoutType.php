<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\Entity\Country;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;
use App\Service\AppServices;

class CheckoutType extends AbstractType {

    private $services;

    public function __construct(AppServices $services) {
        $this->services = $services;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('orderReference', HiddenType::class, [
                    'required' => true,
                    'constraints' => array(
                        new NotBlank(['groups' => ['attendee', 'pos']])
                    ),
                ])
                ->add('firstname', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'First name',
                    'constraints' => array(
                        new NotBlank(['groups' => ['attendee']]),
                        new Length([
                            'min' => 2,
                            'max' => 20,
                            'groups' => ['attendee', 'pos']])
                    ),
                ])
                ->add('lastname', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Last name',
                    'constraints' => array(
                        new NotBlank(['groups' => ['attendee']]),
                        new Length([
                            'min' => 2,
                            'max' => 20,
                            'groups' => ['attendee', 'pos']])
                    ),
                ])
                ->add('email', EmailType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Email',
                    'constraints' => array(
                        new Assert\Email(['groups' => ['attendee']]),
                        new NotBlank(['groups' => ['attendee']]),
                        new Length([
                            'min' => 2,
                            'max' => 30,
                            'groups' => ['attendee']])
                    ),
                ])
                ->add('country', EntityType::class, [
                    'required' => true,
                    'class' => Country::class,
                    'choice_label' => 'name',
                    'label' => 'Country',
                    'attr' => ['class' => 'select2'],
                    'placeholder' => 'Select an option',
                    'constraints' => array(
                        new NotBlank(['groups' => ['attendee']])
                    ),
                    'query_builder' => function() {
                        return $this->services->getCountries(array());
                    },
                ])
                ->add('state', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'State',
                    'constraints' => array(
                        new NotBlank(['groups' => ['attendee']]),
                        new Length([
                            'min' => 2,
                            'max' => 50,
                            'groups' => ['attendee']])
                    ),
                ])
                ->add('city', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'City',
                    'constraints' => array(
                        new NotBlank(['groups' => ['attendee']]),
                        new Length([
                            'min' => 2,
                            'max' => 50,
                            'groups' => ['attendee']])
                    ),
                ])
                ->add('postalcode', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Postal code',
                    'constraints' => array(
                        new NotBlank(['groups' => ['attendee']]),
                        new Length([
                            'min' => 2,
                            'max' => 15,
                            'groups' => ['attendee']])
                    ),
                ])
                ->add('street', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Street',
                    'constraints' => array(
                        new NotBlank(['groups' => ['attendee']]),
                        new Length([
                            'min' => 2,
                            'max' => 50,
                            'groups' => ['attendee']])
                    ),
                ])
                ->add('street2', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Street 2',
                    'constraints' => array(
                        new Length([
                            'max' => 50,
                            'groups' => ['attendee']
                                ])
                    ),
                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'validation_groups' => ['attendee', 'pos']
        ]);
    }

}
