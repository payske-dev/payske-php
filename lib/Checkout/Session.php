<?php

// File generated from our OpenAPI spec

namespace Payske\Checkout;

/**
 * A Checkout Session represents your customer's session as they pay for one-time
 * purchases or subscriptions through <a
 * href="https://docs.payske.com/docs/payments/checkout">Checkout</a>. We recommend
 * creating a new Session each time your customer attempts to pay.
 *
 * Once payment is successful, the Checkout Session will contain a reference to the
 * <a href="https://docs.payske.com/api/customers">Customer</a>, and either the
 * successful <a
 * href="https://docs.payske.com/api/payment_intents">PaymentIntent</a> or an
 * active <a href="https://docs.payske.com/api/subscriptions">Subscription</a>.
 *
 * You can create a Checkout Session on your server and pass its ID to the client
 * to begin Checkout.
 *
 * Related guide: <a href="https://docs.payske.com/docs/payments/checkout/api">Checkout
 * Server Quickstart</a>.
 *
 * @property string $id Unique identifier for the object. Used to pass to <code>redirectToCheckout</code> in Payske.js.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property null|\Payske\PayskeObject $after_expiration When set, provides configuration for actions to take if this Checkout Session expires.
 * @property null|bool $allow_promotion_codes Enables user redeemable promotion codes.
 * @property null|int $amount_subtotal Total of all items before discounts or taxes are applied.
 * @property null|int $amount_total Total of all items after discounts and taxes are applied.
 * @property \Payske\PayskeObject $automatic_tax
 * @property null|string $billing_address_collection Describes whether Checkout should collect the customer's billing address.
 * @property string $cancel_url The URL the customer will be directed to if they decide to cancel payment and return to your website.
 * @property null|string $client_reference_id A unique string to reference the Checkout Session. This can be a customer ID, a cart ID, or similar, and can be used to reconcile the Session with your internal systems.
 * @property null|\Payske\PayskeObject $consent Results of <code>consent_collection</code> for this session.
 * @property null|\Payske\PayskeObject $consent_collection When set, provides configuration for the Checkout Session to gather active consent from customers.
 * @property null|string $currency Three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html">ISO currency code</a>, in lowercase. Must be a <a href="https://docs.payske.com/docs/currencies">supported currency</a>.
 * @property null|string|\Payske\Customer $customer The ID of the customer for this Session. For Checkout Sessions in <code>payment</code> or <code>subscription</code> mode, Checkout will create a new customer object based on information provided during the payment flow unless an existing customer was provided when the Session was created.
 * @property null|\Payske\PayskeObject $customer_details The customer details including the customer's tax exempt status and the customer's tax IDs. Only present on Sessions in <code>payment</code> or <code>subscription</code> mode.
 * @property null|string $customer_email If provided, this value will be used when the Customer object is created. If not provided, customers will be asked to enter their email address. Use this parameter to prefill customer data if you already have an email on file. To access information about the customer once the payment flow is complete, use the <code>customer</code> attribute.
 * @property int $expires_at The timestamp at which the Checkout Session will expire.
 * @property \Payske\Collection $line_items The line items purchased by the customer.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property null|string $locale The IETF language tag of the locale Checkout is displayed in. If blank or <code>auto</code>, the browser's locale is used.
 * @property null|\Payske\PayskeObject $metadata Set of <a href="https://docs.payske.com/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property string $mode The mode of the Checkout Session.
 * @property null|string|\Payske\PaymentIntent $payment_intent The ID of the PaymentIntent for Checkout Sessions in <code>payment</code> mode.
 * @property null|\Payske\PayskeObject $payment_method_options Payment-method-specific configuration for the PaymentIntent or SetupIntent of this CheckoutSession.
 * @property string[] $payment_method_types A list of the types of payment methods (e.g. card) this Checkout Session is allowed to accept.
 * @property string $payment_status The payment status of the Checkout Session, one of <code>paid</code>, <code>unpaid</code>, or <code>no_payment_required</code>. You can use this value to decide when to fulfill your customer's order.
 * @property null|string $recovered_from The ID of the original expired Checkout Session that triggered the recovery flow.
 * @property null|string|\Payske\SetupIntent $setup_intent The ID of the SetupIntent for Checkout Sessions in <code>setup</code> mode.
 * @property null|\Payske\PayskeObject $shipping Shipping information for this Checkout Session.
 * @property null|\Payske\PayskeObject $shipping_address_collection When set, provides configuration for Checkout to collect a shipping address from a customer.
 * @property null|string $submit_type Describes the type of transaction being performed by Checkout in order to customize relevant text on the page, such as the submit button. <code>submit_type</code> can only be specified on Checkout Sessions in <code>payment</code> mode, but not Checkout Sessions in <code>subscription</code> or <code>setup</code> mode.
 * @property null|string|\Payske\Subscription $subscription The ID of the subscription for Checkout Sessions in <code>subscription</code> mode.
 * @property string $success_url The URL the customer will be directed to after the payment or subscription creation is successful.
 * @property \Payske\PayskeObject $tax_id_collection
 * @property null|\Payske\PayskeObject $total_details Tax and discount details for the computed total amount.
 * @property null|string $url The URL to the Checkout Session.
 */
class Session extends \Payske\ApiResource
{
    const OBJECT_NAME = 'checkout.session';

    use \Payske\ApiOperations\All;
    use \Payske\ApiOperations\Create;
    use \Payske\ApiOperations\NestedResource;
    use \Payske\ApiOperations\Retrieve;

    const BILLING_ADDRESS_COLLECTION_AUTO = 'auto';
    const BILLING_ADDRESS_COLLECTION_REQUIRED = 'required';

    const MODE_PAYMENT = 'payment';
    const MODE_SETUP = 'setup';
    const MODE_SUBSCRIPTION = 'subscription';

    const PAYMENT_STATUS_NO_PAYMENT_REQUIRED = 'no_payment_required';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_UNPAID = 'unpaid';

    const SUBMIT_TYPE_AUTO = 'auto';
    const SUBMIT_TYPE_BOOK = 'book';
    const SUBMIT_TYPE_DONATE = 'donate';
    const SUBMIT_TYPE_PAY = 'pay';

    const PATH_LINE_ITEMS = '/line_items';

    /**
     * @param string $id the ID of the session on which to retrieve the items
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Collection the list of items
     */
    public static function allLineItems($id, $params = null, $opts = null)
    {
        return self::_allNestedResources($id, static::PATH_LINE_ITEMS, $params, $opts);
    }
}
