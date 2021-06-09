<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class PaymentGatewayConfigType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('sandbox', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Sandbox',
                    'choices' => ['No' => false, 'Yes' => true],
                    'attr' => ['class' => 'payment_config_field paypal_express_checkout paypal_rest'],
                    'label_attr' => ['class' => 'radio-custom radio-inline']
                ])
                ->add('username', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'attr' => ['class' => 'payment_config_field paypal_express_checkout'],
                ])
                ->add('password', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'attr' => ['class' => 'payment_config_field paypal_express_checkout'],
                ])
                ->add('signature', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'attr' => ['class' => 'payment_config_field paypal_express_checkout'],
                ])
                ->add('publishable_key', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Stripe publishable key',
                    'attr' => ['class' => 'payment_config_field stripe_checkout'],
                ])
                ->add('secret_key', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Stripe secret key',
                    'attr' => ['class' => 'payment_config_field stripe_checkout'],
                ])
                ->add('client_id', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Paypal Client Id',
                    'attr' => ['class' => 'payment_config_field paypal_rest'],
                ])
                ->add('client_secret', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Paypal Client Secret',
                    'attr' => ['class' => 'payment_config_field paypal_rest'],
                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
                // Configure your form options here
        ]);
    }

}
