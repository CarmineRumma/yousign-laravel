<?php

namespace CarmineRumma\YousignLaravel\Models;

class Signers
{
  public string $id;
  public string $status;
  public string $signature_link;
  public string $signature_link_expiration_date;

  /*

  public function __construct(
    string $id,
    string $status,
    string $signature_link,
    string $signature_link_expiration_date
  ) {
    $this->id = $id;
    $this->status = $status;
    $this->signature_link = $signature_link;
    $this->signature_link_expiration_date = $signature_link_expiration_date;
  }
   */
}
