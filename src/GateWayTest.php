<?php

namespace Habeuk\Stripe;

use Habeuk\Stripe\Ressouces\Helpers;
use Stripe\StripeClient;

/**
 *
 * @author stephane
 * @see https://stripe.com/docs/api?lang=php.
 * @see https://stripe.com/docs/payments/quickstart (Tunnele de payement
 *      securisé)
 * @see https://stripe.com/docs/payments/payment-intents (paymentIntents)
 */
class GateWayTest extends GateWayBase {
  
  /**
   *
   * @param float $montant
   *        // example 1.5 ( 1.5€ ).
   *        //montant de la commande.
   * @param String $titre
   *        //titre de la commande.
   */
  public function paidInvoice(float $montant = 1, String $titre = 'null') {
    $this->init();
    $montant = $montant * 100;
    $paymentIntents = $this->stripeApi->paymentIntents->create([
      'amount' => $montant,
      'currency' => 'eur',
      'payment_method_types' => [
        'card'
      ]
    ]);
    
    /**
     * Le status doit permettre de determiner la suite du procces.
     *
     * @see https://stripe.com/docs/payments/paymentintents/lifecycle#intent-statuses
     */
    $paymentIntents->status;
    return $paymentIntents;
  }
  
}