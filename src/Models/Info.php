<?php

namespace CarmineRumma\YousignLaravel\Models;

class Info
{
  public string $firstName;
  public string $lastName;
  public string $email;
  public string $phoneNumber;
  public string $locale;

  public function __construct(
    string $firstName,
    string $lastName,
    string $email,
    string $phoneNumber,
    string $locale
  ) {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->email = $email;
    $this->phoneNumber = $phoneNumber;
    $this->locale = $locale;
  }
}
