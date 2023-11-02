<?php

namespace CarmineRumma\YousignLaravel\DTO;

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
