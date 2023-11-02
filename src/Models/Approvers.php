<?php

namespace CarmineRumma\YousignLaravel\Models;

class Approvers
{
  public string $id;
  public string $status;
  public string $approval_link;
  public string $approval_link_expiration_date;

  /*
   public function __construct(
    string $id,
    string $status,
    string $approval_link,
    string $approval_link_expiration_date
  ) {
    $this->id = $id;
    $this->status = $status;
    $this->approval_link = $approval_link;
    $this->approval_link_expiration_date = $approval_link_expiration_date;
  }
   */
}
