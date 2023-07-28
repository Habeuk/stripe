<?php

namespace Habeuk\Stripe;

use Stripe\Stripe;
use Stripe\Balance;
use Habeuk\Stripe\Exception\ExceptionStripe;

class GateWay extends GateWayBase {
  
  public function attachPaymentMethodToPaymentIntents(string $id, string $paymentIntentId) {
    $this->init();
    return $this->stripeApi->paymentMethods->attach($id, [
      'payment_intent' => $paymentIntentId
    ]);
  }
  
  public function UpdatePaymentIntents(string $paymentIntentId, float $montant = null, String $titre = null, string $currency = null, $customerId = null, $description = null, $receipt_email = null) {
    $this->init();
    $datas = [];
    if ($montant) {
      $montant = $montant * 100;
      $datas['amount'] = $montant;
    }
    if ($titre) {
      $datas['description'] = $titre;
    }
    return $this->stripeApi->paymentIntents->update($paymentIntentId, $datas);
  }
  
  /**
   * on informe stripe stripe de l'inention de paiement.
   *
   * @param float $montant
   *        // example 1.5 ( 1.5€ ).
   *        //montant de la commande.
   * @param String $titre
   *        //titre de la commande.
   */
  public function CreatePaymentIntents(float $montant = 1, String $titre = null, string $currency = 'eur', $customerId = null, $receipt_email = null) {
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
    if ($titre)
      $datas['description'] = $titre;
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
  
  /**
   * Permet de tester que les deux clées fournit sont valide et aussi de
   * s'assurer qu'on est soit en production soit en developpement.
   */
  function testValidationKey($expected_livemode = true) {
    $this->init();
    if (Balance::retrieve()->offsetGet('livemode') != $expected_livemode) {
      throw ExceptionStripe::exception("La clée fournit ne correspond pas au mode 'production'", $this->getSecretKey());
    }
  }
  
}