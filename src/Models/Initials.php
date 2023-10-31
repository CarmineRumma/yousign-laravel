<?php
namespace CarmineRumma\YousignLaravel\Models;

class Initials
{
  public string $alignment;
  public int $y;

  public function __construct(string $alignment, int $y)
  {
    $this->alignment = $alignment;
    $this->y = $y;
  }
}
