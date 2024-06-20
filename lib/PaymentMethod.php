<?php

// File generated from our OpenAPI spec

namespace Payske;

/**
 * PaymentMethod objects represent your customer's payment instruments. They can be
 * used with <a
 * href="https://docs.payske.com/docs/payments/payment-intents">PaymentIntents</a> to
 * collect payments or saved to Customer objects to store instrument details for
 * future payments.
 *
 * Related guides: <a
 * href="https://docs.payske.com/docs/payments/payment-methods">Payment Methods</a> and
 * <a href="https://docs.payske.com/docs/payments/more-payment-scenarios">More Payment
 * Scenarios</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property \Payske\PayskeObject $acss_debit
 * @property \Payske\PayskeObject $afterpay_clearpay
 * @property \Payske\PayskeObject $alipay
 * @property \Payske\PayskeObject $au_becs_debit
 * @property \Payske\PayskeObject $bacs_debit
 * @property \Payske\PayskeObject $bancontact
 * @property \Payske\PayskeObject $billing_details
 * @property \Payske\PayskeObject $boleto
 * @property \Payske\PayskeObject $card
 * @property \Payske\PayskeObject $card_present
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property null|string|\Payske\Customer $customer The ID of the Customer to which this PaymentMethod is saved. This will not be set when the PaymentMethod has not been saved to a Customer.
 * @property \Payske\PayskeObject $eps
 * @property \Payske\PayskeObject $fpx
 * @property \Payske\PayskeObject $giropay
 * @property \Payske\PayskeObject $grabpay
 * @property \Payske\PayskeObject $ideal
 * @property \Payske\PayskeObject $interac_present
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property null|\Payske\PayskeObject $metadata Set of <a href="https://docs.payske.com/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property \Payske\PayskeObject $oxxo
 * @property \Payske\PayskeObject $p24
 * @property \Payske\PayskeObject $sepa_debit
 * @property \Payske\PayskeObject $sofort
 * @property string $type The type of the PaymentMethod. An additional hash is included on the PaymentMethod with a name matching this value. It contains additional information specific to the PaymentMethod type.
 * @property \Payske\PayskeObject $wechat_pay
 */
class PaymentMethod extends ApiResource
{
    const OBJECT_NAME = 'payment_method';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\PaymentMethod the attached payment method
     */
    public function attach($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/attach';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\PaymentMethod the detached payment method
     */
    public function detach($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/detach';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }
}
