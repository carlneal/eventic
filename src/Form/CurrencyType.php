<?php

namespace App\Form;

use App\Entity\Currency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CurrencyType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('ccy', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'CCY',
                    'help' => 'Please refer to this following list and use the Code column: https://en.wikipedia.org/wiki/ISO_4217'
                ])
                ->add('symbol', TextType::class, [
                    'purify_html' => true,
                    'required' => true,
                    'label' => 'Currency symbol'
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Currency::class,
        ]);
    }

}
