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
 * @see https://stripe.com/docs/api/payment_intents/create?lang=php
 *      (paymentIntents)
 */
class GateWayTest extends GateWayBase {
  
  /**
   * on informe stripe stripe de l'inention de paiement.
   *
   * @param float $montant
   *        // example 1.5 ( 1.5€ ).
   *        //montant de la commande.
   * @param String $titre
   *        //titre de la commande.
   */
  public function CreatePaymentIntents(float $montant = 1, String $titre = 'null', string $currency = 'eur', $customerId = null, $description = null, $receipt_email = null) {
    $this->init();
    $montant = $montant * 100;
    $this->validCurrency($currency);
    $datas = [
      // il ya une limite en function de la devise.
      'amount' => $montant,
      'currency' => $currency,
      'payment_method_types' => $this->getPaymentMethodTypes(),
      // On cree juste l'instance, à ce niveau.( on ne paye pas directement ).
      'confirm' => false
    ];
    if ($description)
      $datas['description'] = $description;
    if ($customerId)
      $datas['customer'] = $customerId;
    if ($receipt_email)
      $datas['receipt_email'] = $receipt_email;
    // on envoit cela sur Stripe.
    $paymentIntents = $this->stripeApi->paymentIntents->create($datas);
    //
    
    /**
     * Le status doit permettre de determiner la suite du procces.
     *
     * @see https://stripe.com/docs/payments/paymentintents/lifecycle#intent-statuses
     */
    $paymentIntents->status;
    return $paymentIntents;
  }
  
}