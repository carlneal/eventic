<?php

declare(strict_types = 1);

namespace App\Form\Extension;

use App\Form\PaymentGatewayType;
use App\Form\OrganizerPayoutPaymentGatewayType;
use Payum\Core\Security\CryptedInterface;
use Payum\Core\Security\CypherInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CryptedGatewayConfigTypeExtension extends AbstractTypeExtension {

    private $cypher;

    public function __construct(CypherInterface $cypher = null) {
        $this->cypher = $cypher;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        if (null === $this->cypher) {
            return;
        }

        $builder
                // Before set form data, we decrypt the gateway config
                ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                    $gatewayConfig = $event->getData();

                    if (!$gatewayConfig instanceof CryptedInterface) {
                        return;
                    }

                    $gatewayConfig->decrypt($this->cypher);

                    $event->setData($gatewayConfig);
                })
                // After submitting the form, we encrypt the gateway back
                ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                    $gatewayConfig = $event->getData();

                    if (!$gatewayConfig instanceof CryptedInterface) {
                        return;
                    }

                    $gatewayConfig->encrypt($this->cypher);

                    $event->setData($gatewayConfig);
                });
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedTypes(): array {
        // The extension will be applied on `PaypalGatewayConfigType` form type.
        // Feel free to add another form types if needed.
        return [PaymentGatewayType::class, OrganizerPayoutPaymentGatewayType::class];
    }

}
