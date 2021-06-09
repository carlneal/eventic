<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Country;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;
use App\Service\AppServices;

class AccountSettingsType extends AbstractType {

    private $services;

    public function __construct(AppServices $services) {
        $this->services = $services;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', EmailType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Email',
                    'constraints' => array(
                        new Assert\Email(),
                        new NotBlank(),
                        new Length([
                            'min' => 2,
                            'max' => 30])
                    ),
                    'attr' => ['readonly' => true]
                ])
                ->add('username', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Username',
                    'constraints' => array(
                        new NotBlank(),
                        new Length([
                            'min' => 2,
                            'max' => 30])
                    ),
                    'attr' => ['readonly' => true]
                ])
                ->add('firstname', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'First name'
                ])
                ->add('lastname', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Last name'
                ])
                ->add('phone', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Phone number'
                ])
                ->add('birthdate', DateType::class, [
                    'required' => false,
                    'label' => 'Birthdate',
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => ['class' => 'datepicker']
                ])
                ->add('avatarFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => true,
                    'download_label' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                    'imagine_pattern' => 'scale',
                    'label' => 'Profile picture',
                    'translation_domain' => 'messages'
                ])
                ->add('street', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Street address',
                ])
                ->add('street2', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Street address 2',
                ])
                ->add('city', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'City',
                ])
                ->add('postalcode', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'Zip / Postal code',
                ])
                ->add('state', TextType::class, [
                    'purify_html' => true,
                    'required' => false,
                    'label' => 'State',
                ])
                ->add('country', EntityType::class, [
                    'required' => false,
                    'class' => Country::class,
                    'choice_label' => 'name',
                    'label' => 'Country',
                    'attr' => ['class' => 'select2'],
                    'placeholder' => 'Select an option',
                    'query_builder' => function() {
                        return $this->services->getCountries(array());
                    },
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
