<?php
namespace CarmineRumma\YousignLaravel\DTO;

class ReminderSettings
{
  public int $intervalInDays;
  public int $maxOccurrences;

  public function __construct(int $intervalInDays, int $maxOccurrences)
  {
    $this->intervalInDays = $intervalInDays;
    $this->maxOccurrences = $maxOccurrences;
  }
}
