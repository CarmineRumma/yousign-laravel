<?php

namespace CarmineRumma\YousignLaravel\Models;

class RedirectUrls
{
  public $success;
  public $error;

  public function __construct($success, $error)
  {
    $this->success = $success;
    $this->error = $error;
  }
}
