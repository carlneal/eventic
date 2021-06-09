<?php

namespace App\Form;

use App\Entity\PaymentGateway;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\PaymentGatewayConfigType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrganizerPayoutPaymentGatewayType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('config', PaymentGatewayConfigType::class, [
                    'label' => false,
                    'auto_initialize' => false,
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => PaymentGateway::class,
        ]);
    }

}
