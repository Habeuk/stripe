<?php

namespace Habeuk\Stripe\Ressouces;

trait Helpers {
  
  /**
   * Cette fonction permet de valider la clée.
   */
  function validKey(string $secret_key) {
    // else return exception// il faudra un mail pour cette eception.
    return true;
  }
  
}