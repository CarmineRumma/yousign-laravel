<?php
namespace CarmineRumma\YousignLaravel\Models;

class Sender
{
  public string $type;
  public null $customName;

  public function __construct(string $type, ?string $customName)
  {
    $this->type = $type;
    $this->customName = $customName;
  }
}
