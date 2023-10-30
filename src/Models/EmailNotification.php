<?php
namespace CarmineRumma\YousignLaravel\Models;

class EmailNotification
{
  public Sender $sender;

  public function __construct(Sender $sender)
  {
    $this->sender = $sender;
  }
}
