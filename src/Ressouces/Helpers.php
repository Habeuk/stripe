<?php

namespace Habeuk\Stripe\Ressouces;

use Habeuk\Stripe\Exception\ExceptionStripe;

trait Helpers {
  
  /**
   * Cette fonction permet de valider la clée.
   */
  function validKey(string $secret_key) {
    // else return exception// il faudra un mail pour cette eception.
    if (empty($secret_key))
      throw ExceptionStripe::exception("La clée secrete est vide", $secret_key);
    // on doit effectuer une validation basique de la syntaxe.
    return true;
  }
  
  function validCurrency(string $currency) {
    //
    return true;
  }
  
}