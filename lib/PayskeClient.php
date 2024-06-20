<?php

// File generated from our OpenAPI spec

namespace Payske;

/**
 * Client used to send requests to Payske's API.
 *
 * @property \Payske\Service\AccountLinkService $accountLinks
 * @property \Payske\Service\AccountService $accounts
 * @property \Payske\Service\ApplePayDomainService $applePayDomains
 * @property \Payske\Service\ApplicationFeeService $applicationFees
 * @property \Payske\Service\BalanceService $balance
 * @property \Payske\Service\BalanceTransactionService $balanceTransactions
 * @property \Payske\Service\BillingPortal\BillingPortalServiceFactory $billingPortal
 * @property \Payske\Service\ChargeService $charges
 * @property \Payske\Service\Checkout\CheckoutServiceFactory $checkout
 * @property \Payske\Service\CountrySpecService $countrySpecs
 * @property \Payske\Service\CouponService $coupons
 * @property \Payske\Service\CreditNoteService $creditNotes
 * @property \Payske\Service\CustomerService $customers
 * @property \Payske\Service\DisputeService $disputes
 * @property \Payske\Service\EphemeralKeyService $ephemeralKeys
 * @property \Payske\Service\EventService $events
 * @property \Payske\Service\ExchangeRateService $exchangeRates
 * @property \Payske\Service\FileLinkService $fileLinks
 * @property \Payske\Service\FileService $files
 * @property \Payske\Service\Identity\IdentityServiceFactory $identity
 * @property \Payske\Service\InvoiceItemService $invoiceItems
 * @property \Payske\Service\InvoiceService $invoices
 * @property \Payske\Service\Issuing\IssuingServiceFactory $issuing
 * @property \Payske\Service\MandateService $mandates
 * @property \Payske\Service\OAuthService $oauth
 * @property \Payske\Service\OrderReturnService $orderReturns
 * @property \Payske\Service\OrderService $orders
 * @property \Payske\Service\PaymentIntentService $paymentIntents
 * @property \Payske\Service\PaymentMethodService $paymentMethods
 * @property \Payske\Service\PayoutService $payouts
 * @property \Payske\Service\PlanService $plans
 * @property \Payske\Service\PriceService $prices
 * @property \Payske\Service\ProductService $products
 * @property \Payske\Service\PromotionCodeService $promotionCodes
 * @property \Payske\Service\QuoteService $quotes
 * @property \Payske\Service\Radar\RadarServiceFactory $radar
 * @property \Payske\Service\RefundService $refunds
 * @property \Payske\Service\Reporting\ReportingServiceFactory $reporting
 * @property \Payske\Service\ReviewService $reviews
 * @property \Payske\Service\SetupAttemptService $setupAttempts
 * @property \Payske\Service\SetupIntentService $setupIntents
 * @property \Payske\Service\Sigma\SigmaServiceFactory $sigma
 * @property \Payske\Service\SkuService $skus
 * @property \Payske\Service\SourceService $sources
 * @property \Payske\Service\SubscriptionItemService $subscriptionItems
 * @property \Payske\Service\SubscriptionScheduleService $subscriptionSchedules
 * @property \Payske\Service\SubscriptionService $subscriptions
 * @property \Payske\Service\TaxCodeService $taxCodes
 * @property \Payske\Service\TaxRateService $taxRates
 * @property \Payske\Service\Terminal\TerminalServiceFactory $terminal
 * @property \Payske\Service\TokenService $tokens
 * @property \Payske\Service\TopupService $topups
 * @property \Payske\Service\TransferService $transfers
 * @property \Payske\Service\WebhookEndpointService $webhookEndpoints
 */
class PayskeClient extends BasePayskeClient
{
    /**
     * @var \Payske\Service\CoreServiceFactory
     */
    private $coreServiceFactory;

    public function __get($name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new \Payske\Service\CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->__get($name);
    }
}
