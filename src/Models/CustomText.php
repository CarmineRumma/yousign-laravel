<?php

namespace CarmineRumma\YousignLaravel\Models;

class CustomText
{
  public $requestSubject;
  public $requestBody;
  public $reminderSubject;
  public $reminderBody;

  public function __construct(
    $requestSubject,
    $requestBody,
    $reminderSubject,
    $reminderBody
  ) {
    $this->requestSubject = $requestSubject;
    $this->requestBody = $requestBody;
    $this->reminderSubject = $reminderSubject;
    $this->reminderBody = $reminderBody;
  }
}
