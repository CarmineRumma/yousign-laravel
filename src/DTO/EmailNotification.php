<?php
namespace CarmineRumma\YousignLaravel\DTO;

class EmailNotification
{
  public Sender $sender;

  public function __construct(Sender $sender)
  {
    $this->sender = $sender;
  }
}
