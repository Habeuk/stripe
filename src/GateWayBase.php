<?php

namespace Habeuk\Stripe;

use Habeuk\Stripe\Ressouces\Helpers;
use Stripe\StripeClient;

/**
 * --
 *
 *
 *
 * @author stephane
 * @see https://stripe.com/docs/api?lang=php.
 * @see https://stripe.com/docs/payments/quickstart (Tunnele de payement
 *      securisé)
 */
class GateWayBase implements GateWayInterface {
  use Helpers;
  
  /**
   * the secret keys have the prefix sk_test_ for mode test and sk_live_ for
   * live mode.
   *
   * @var string
   */
  private $secret_key = null;
  
  /**
   * Type de methode de payements
   *
   * @var array
   */
  private $payment_method_types = [
    'card'
  ];
  
  /**
   * Autorize tous les types de methodes paiement.
   *
   * @var boolean
   */
  private $automatic_payment_methods = true;
  
  /**
   *
   * @var \Stripe\StripeClient
   */
  protected $stripeApi;
  
  function __construct(string $secret_key = null) {
    if ($secret_key) {
      $this->validKey($secret_key);
      $this->secret_key = $secret_key;
      $this->stripeApi = new StripeClient($this->secret_key);
    }
  }
  
  function setSecretKey(string $secret_key) {
    $this->validKey($secret_key);
    $this->secret_key = $secret_key;
  }
  
  /**
   * On initialise la passerelle.
   *
   * @return \Stripe\StripeClient
   */
  protected function init() {
    if (!$this->stripeApi) {
      $this->validKey($this->secret_key);
      $this->stripeApi = new StripeClient($this->secret_key);
    }
    return $this->stripeApi;
  }
  
}