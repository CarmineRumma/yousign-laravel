<?php

namespace CarmineRumma\YousignLaravel\Request;
use CarmineRumma\YousignLaravel\DTO\EmailNotification;
use CarmineRumma\YousignLaravel\DTO\ReminderSettings;

class AddDocumentToSignatureRequest
{
  public string $signatureRequestId;
  public string $file;
}
